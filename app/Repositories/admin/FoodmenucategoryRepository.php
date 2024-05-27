<?php

namespace App\Repositories\admin;

use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\ImageUploadTrait;
use App\Interfaces\admin\FoodmenucategoryRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\admin\Foodmenucategory;
use App\Models\admin\Foodmenusubcategory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

class FoodmenucategoryRepository implements FoodmenucategoryRepositoryInterface
{
    use ImageUploadTrait;
    public function getFoodMenuCategoryData()
    {
        return Foodmenucategory::whereNull('deleted_at')->get();
    }
    public function getFoodMenusubCategoryData($sid)
    {
        return Foodmenusubcategory::where('category_id', $sid)->whereNull('deleted_at')->get();
    }
    public function getFoodMenusubCategoryDataAll()
    {
        return Foodmenusubcategory::select('id', 'name')->whereNull('deleted_at')->get();
    }

    public function storeFoodMenuCategory(Request $request)
    {

        $data = $request->all();

        $id = Auth::user()->id;
        $data['created_by'] = $id;
        $menucategory = Foodmenucategory::create($data);

        if ($request->hasFile('image')) {
            $files = $request->file('image');
            foreach ($files as $file) {
                $image[] = $this->uploadImage($file, 'food_menu_sub_category');
            }
        }
        foreach ($request->subcategory_name as $key => $value) {
            $savedata = [
                'category_id' => $menucategory->id,
                'name' => $value,
                'image' => $image[$key],
                'created_by' => Auth::user()->id,
            ];

            Foodmenusubcategory::create($savedata);
        }
        return true;
    }
    public function updateFoodMenuCategory(Request $request, $id)
    {
        $updateCategory = $this->getSingleFoodMenuCategory($id);
        $data = $request->all();
        $id = Auth::user()->id;
        $data['updated_by'] = $id;
        $updateCategory->update($data);

        $updateSubCategory = $this->getMultipleFoodMenuCategory($id);



        if ($request->hasFile('image')) {
            $files = $request->file('image');
            foreach ($files as $file) {
                $image[] = $this->uploadImage($file, 'food_menu_sub_category');
            }
        } else {
            $image[] = $updateSubCategory->image;
        }


        if ($request->subcategory_name != "") {
            foreach ($request->subcategory_name as $key => $value) {
                $updateSubCategory = [
                    'category_id' => $updateCategory->id,
                    'name' => $value,
                    'image' => $image[$key],
                    'created_by' => Auth::user()->id,
                ];
            }
            $updateData = Foodmenusubcategory::where('category_id', $id)->update($updateSubCategory);
        }
        return true;
    }

    public function getSingleFoodMenuCategory($id)
    {
        return Foodmenucategory::with('subCategory')->findorfail($id);
    }

    public function getMultipleFoodMenuCategory($id)
    {

        return Foodmenusubcategory::where('category_id', $id)->get();
    }


    public function getDataFoodMenuCategory(Request $request)
    {
        $searchName = $request->query('search_food_category_name');

        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', array(1, 'asc'));


        $sortcolumns = array(
            0 => 'fs_food_menu_category.name',
            1 => 'fs_food_menu_category.category_id',
        );

        $query = Foodmenucategory::select('*')->with('subCategory');

        if (!empty($searchName)) {
            $query->where('name', 'like', '%' . $searchName . '%');
        }

        $recordstotal = $query->count();
        $sortColumnName = $sortcolumns[$order[0]['column']];

        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $json = array(
            'draw' => $draw,
            'recordsTotal' => $recordstotal,
            'recordsFiltered' => $recordstotal,
            'data' => [],
        );

        $foodMenuCategory = $query->orderBy('created_at', 'desc')->get();

        $subCategoryArr = [];
        foreach ($foodMenuCategory as $category) {
            $url = route("food-menu-category.show", $category->id);
            $nameAction = $category->name != "" ? "<a href='" . $url . "'>" . $category->name . "</a>" : 'N/A';
            if ($category->subCategory) {

                foreach ($category->subCategory as $subCat) {
                    $subCategoryArr[] = $subCat->name;
                }
            }

            $json['data'][] = [
                $nameAction,
                $subCategoryArr,
            ];
        }
        return $json;
    }

    public function destroyFoodMenuCategory($id)
    {
        $foodMenuCategory = $this->getSingleFoodMenuCategory($id);

        $foodMenuCategory->delete();

        return $foodMenuCategory;
    }
}
