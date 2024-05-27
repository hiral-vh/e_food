<?php

namespace App\Repositories\admin;

use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\ImageUploadTrait;
use App\Interfaces\admin\MenuRepositoryInterface;
use App\Models\admin\Foodcategory;
use App\Models\admin\Foodmenucategory;
use App\Models\admin\Menu;
use App\Models\admin\Menuattribute;
use App\Models\admin\MenuCategory;
use App\Models\admin\MenuExtraItem;
use App\Models\admin\RemoveIngredients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuRepository implements MenuRepositoryInterface
{
    use ImageUploadTrait;

    public function getAllFoodMenu()
    {
        return Menu::with(['category', 'menuCategory'])->get();
    }
    public function getMenuCategory()
    {
        return MenuCategory::pluck('title', 'id');
    }
    public function getAllmenuSubcategorywise($id, $sub_category_id)
    {
        return Menu::where('sub_category_id', $sub_category_id)->where('restaurant_id', $id)->where('status', '1')->whereNull('deleted_at')->get();
    }
    public function getAllmenuMenuCategorywise($id, $menu_category_id)
    {
        return Menu::where("restaurant_id", $id)->where("menu_category_id", $menu_category_id)->groupBy('name')->get();
    }

    public function getAllmenuAttribute($id, $menuid)
    {
        return Menuattribute::where('menu_id', $menuid)->where('restaurant_id', $id)->whereNull('deleted_at')->get();
    }

    public function getAllExtraItems($id, $menuid)
    {
        return MenuExtraItem::where('menu_id', $menuid)->where('restaurant_id', $id)->whereNull('deleted_at')->get();
    }

    public function getAllRemoveIngredients($id, $menuid)
    {
        return RemoveIngredients::where('menu_id', $menuid)->where('restaurant_id', $id)->whereNull('deleted_at')->get();
    }

    public function getMenubyIdwise($id)
    {
        return Menu::where('id', $id)->where('status', '1')->whereNull('deleted_at')->first();
    }

    public function storeFoodMenu(Request $request)
    {
        $data['menu_category_id'] = $request->menu_category_id;
        $data['name'] = $request->name;
        $data['description'] = $request->description;
        $data['price'] = $request->price;
        $image = "";
        if ($request->hasFile('image')) {
            $image = $this->uploadImage($request->file('image'), 'menu');
        }
        $restarantId = Auth::guard('restaurantportal')->user()->id;
        $data['image'] = $image;
        $data['restaurant_id'] = $restarantId;
        $data['created_by'] = Auth::guard('restaurantportal')->user()->id;
        $data['status'] = '1';
        $data['is_attribute'] = $request->is_attribute;
        $attribute_nameArray = $request['attribute_name'];
        $attribute_priceArray = $request['attribute_price'];
        $item_nameArray = $request['item_name'];
        $item_priceArray = $request['item_price'];
        $ingredients_nameArray = $request['ingredients_name'];
        foreach ($request->category as $key => $value) {
            $data['category_id'] = $value;
            $insert = Menu::create($data);
            if (!empty($attribute_nameArray) || !empty($attribute_priceArray)) {
                for ($i = 0; $i < count($attribute_nameArray); $i++) {

                    $attributeData = array(
                        'restaurant_id' => $restarantId,
                        'menu_id' => $insert['id'],
                        'attribute_name' => $request['attribute_name'][$i],
                        'attribute_price' => $request['attribute_price'][$i],
                        'created_by' => $restarantId,
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    Menuattribute::insert($attributeData);
                }
            }

            if (!empty($item_nameArray) || !empty($item_priceArray)) {
                for ($i = 0; $i < count($item_nameArray); $i++) {

                    $itemData = array(
                        'restaurant_id' => $restarantId,
                        'menu_id' => $insert['id'],
                        'item_name' => $request['item_name'][$i],
                        'item_price' => $request['item_price'][$i],
                        'created_by' => $restarantId,
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    MenuExtraItem::insert($itemData);
                }
            }

            if (!empty($ingredients_nameArray)) {
                for ($i = 0; $i < count($ingredients_nameArray); $i++) {

                    $ingredientsData = array(
                        'restaurant_id' => $restarantId,
                        'menu_id' => $insert['id'],
                        'ingredients_name' => $request['ingredients_name'][$i],
                        'created_by' => $restarantId,
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    RemoveIngredients::insert($ingredientsData);
                }
            }
        }
        return true;
    }

    public function updateFoodMenu(Request $request, $id)
    {
        $updateMenu = $this->getSingleFoodMenu($id);
        $data['restaurant_id'] = $request->restaurant_id;
        $data['menu_category_id'] = $request->menu_category_id;
        $data['name'] = $request->name;
        $data['description'] = $request->description;
        $data['price'] = $request->price;
        $data['status'] = '1';
        $image = "";
        if ($request->hasFile('image')) {
            $image = $this->uploadImage($request->file('image'), 'menu');
        } else {
            $image = $updateMenu->image;
        }

        $restarantId = Auth::guard('restaurantportal')->user()->id;;
        $data['image'] = $image;
        $data['restaurant_id'] = $restarantId;
        $data['is_attribute'] = $request->is_attribute;
        $attribute_nameArray = $request['attribute_name'];
        $attribute_priceArray = $request['attribute_price'];
        $item_nameArray = $request['item_name'];
        $item_priceArray = $request['item_price'];
        $ingredients_nameArray = $request['ingredients_name'];
        $data['created_by'] = Auth::guard('restaurantportal')->user()->id;;

        $menu = $this->getSingleFoodMenu($id);
        $menuByName = $this->getFoodMenusByName($menu->name);
        foreach ($menuByName as $key => $value) {
            $this->getSingleFoodMenu($value->id)->delete();
        }
        foreach ($request->category as $key => $value) {
            $data['category_id'] = $value;
            $insert = Menu::create($data);
            if ($insert) {
                Menuattribute::where('menu_id', $insert->id)->delete();
                MenuExtraItem::where('menu_id', $insert->id)->delete();
                RemoveIngredients::where('menu_id', $insert->id)->delete();
            }
            if (!empty($attribute_nameArray) || !empty($attribute_priceArray)) {

                for ($i = 0; $i < count($attribute_nameArray); $i++) {
                    $attributeData = array(
                        'restaurant_id' => $restarantId,
                        'menu_id' => $insert['id'],
                        'attribute_name' => $request['attribute_name'][$i],
                        'attribute_price' => $request['attribute_price'][$i],
                        'created_by' => $restarantId,
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    Menuattribute::insert($attributeData);
                }
            }

            if (!empty($item_nameArray) || !empty($item_priceArray)) {
                for ($i = 0; $i < count($item_nameArray); $i++) {

                    $itemData = array(
                        'restaurant_id' => $restarantId,
                        'menu_id' => $insert['id'],
                        'item_name' => $request['item_name'][$i],
                        'item_price' => $request['item_price'][$i],
                        'created_by' => $restarantId,
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    MenuExtraItem::insert($itemData);
                }
            }

            if (!empty($ingredients_nameArray)) {
                for ($i = 0; $i < count($ingredients_nameArray); $i++) {

                    $ingredientsData = array(
                        'restaurant_id' => $restarantId,
                        'menu_id' => $insert['id'],
                        'ingredients_name' => $request['ingredients_name'][$i],
                        'created_by' => $restarantId,
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    RemoveIngredients::insert($ingredientsData);
                }
            }
        }
        return true;
    }

    public function getSingleFoodMenu($id)
    {
        return Menu::with('category')->with('menuCategory')->with('menuAttribute')->with('menuExtraItem')->with('removeIngredients')->findOrFail($id);
    }

    public function getFoodMenusByName($name)
    {
        return Menu::where('name', $name)->get();
    }

    public function getSingleFoodMenuAttibute($id)
    {
        return Menuattribute::where('menu_id', $id)->whereNull('deleted_at')->get();
    }

    public function getSingleFoodMenuExtraItem($id)
    {
        return MenuExtraItem::where('menu_id', $id)->whereNull('deleted_at')->get();
    }

    public function getRemoveIngredients($id)
    {
        return RemoveIngredients::where('menu_id', $id)->whereNull('deleted_at')->get();
    }

    public function getDataFoodMenu(Request $request)
    {

        $searchName = $request->query('search_name');
        $searchPrice = $request->query('price');

        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', array(1, 'asc'));


        $sortcolumns = array(
            0 => 'fs_menu.name',
            1 => 'fs_menu.menu_category_id',
        );

        $query = Menu::with(['category', 'menuCategory'])->select('*')->where('restaurant_id', auth()->user()->id);
        if (!empty($searchName)) {
            $query->where('name', 'like', '%' . $searchName . '%');
        }
        if (!empty($searchPrice)) {
            $query->where('price', 'like', '%' . $searchPrice . '%');
        }

        $recordstotal = $query->groupBy('name')->count();
        $sortColumnName = $sortcolumns[$order[0]['column']];

        $query
            ->take($length)
            ->skip($start);

        $json = array(
            'draw' => $draw,
            'recordsTotal' => $recordstotal,
            'recordsFiltered' => $recordstotal,
            'data' => [],
        );

        $foodmenu = $query->latest()->groupBy('name')->get();

        $no =  $start + 1;
        foreach ($foodmenu as $menu) {

            $url = route("food-menu.show", $menu->id);
            $menuName = substr($menu->name, 0, 10);
            $otherChr = '';
            if (strlen($menu->name) > 10) {
                $otherChr = '...';
            }
            $nameAction = "<a href='" . $url . "'>" . $menuName . '' . $otherChr . "</a>";

            $menuCategory = isset($menu->menuCategory) != null ? $menu->menuCategory->title : 'NA';

            $price = '&#163; ' . $menu->price;
            $checkStatus = $menu->status ? 'checked' : '';
            $status = '<input  data-id=' . $menu->id . ' class="updateStatus" type="checkbox" data-onstyle="danger" data-offstyle="primary" data-toggle="toggle" data-on="Active" data-off="Inactive" ' . $checkStatus . ' >';
            $json['data'][] = [
                $no,
                $nameAction,
                $menuCategory,
                $price,
                $status,
            ];

            $no++;
        }
        return $json;
    }

    public function destroyFoodMenu($id)
    {
        $menu = $this->getSingleFoodMenu($id);
        return $this->getSingleFoodMenu($id)->where('name', $menu->name)->delete();
    }

    public function getMenuData()
    {
        return Foodmenucategory::pluck('name', 'id');
    }

    public function getUpdatedStatus(Request $request)
    {
        $dataUpdate = $this->getSingleFoodMenu($request->menuItemId);
        $dataUpdate->update(["status" => $request->status]);
        return $dataUpdate;
    }
}
