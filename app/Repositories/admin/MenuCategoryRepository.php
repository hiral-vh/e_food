<?php

namespace App\Repositories\admin;

use App\Interfaces\admin\MenuCategoryRepositoryInterface;
use App\Models\admin\MenuCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuCategoryRepository implements MenuCategoryRepositoryInterface
{
    public function getMenuCategory()
    {
        return MenuCategory::where('created_by', Auth::user()->id)->get();
    }

    public function getAllMenuCategory()
    {
        return MenuCategory::get();
    }

    public function storeMenuCategory(Request $request)
    {
        $data = $request->all();
        $id = Auth::user()->id;
        $data['created_by'] = $id;
        return MenuCategory::create($data);
    }

    public function getSingleMenuCategory($id)
    {
        return MenuCategory::findorfail($id);
    }

    public function updateMenuCategory(Request $request, $id)
    {
        $data['title'] = $request->title;
        $userId = Auth::user()->id;
        $data['updated_by'] = $userId;
        $updateData = MenuCategory::find($id)->update($data);
        return $updateData;
    }

    public function destroyMenuCategory($id)
    {
        $menuCategory = MenuCategory::find($id)->delete();
        return $menuCategory;
    }

    public function getMenuCategoryTableData(Request $request)
    {
        $searchName = $request->query('search_menu_category_name');

        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', array(1, 'asc'));


        $sortcolumns = array(
            0 => 'menu_category.title',
        );

        $query = MenuCategory::select('*');

        if (!empty($searchName)) {
            $query->where('title', 'like', '%' . $searchName . '%');
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

        $cuisineData = $query->orderBy('created_at', 'desc')->where('created_by', Auth::user()->id)->get();
        foreach ($cuisineData as $cuisine) {
            $url = route("menu-category.show", $cuisine->id);
            $nameAction = $cuisine->title != "" ? "<a href='" . $url . "'>" . $cuisine->title . "</a>" : 'N/A';

            $json['data'][] = [
                $nameAction,

            ];
        }
        return $json;
    }
}
