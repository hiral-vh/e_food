<?php

namespace App\Repositories\admin;

use App\Interfaces\admin\FoodcategotyRepositoryInterface;
use App\Http\Traits\ImageUploadTrait;
use App\Models\admin\Foodcategory;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FoodcategotyRepository implements FoodcategotyRepositoryInterface
{
    use ImageUploadTrait;
    public function getFoodCategorydata()
    {
        return Foodcategory::get();
    }

    public function getFoodCategorydataNew()
    {
        return Foodcategory::pluck('food_category_name', 'id');
    }
    public function storeFoodCategory(Request $request)
    {
        $data = $request->all();
        $image = "";
        if ($request->hasFile('food_category_image')) {
            $image = $this->uploadImage($request->file('food_category_image'), 'food_category');
        }
        $id = Auth::user()->id;
        $data['food_category_image'] = $image;
        $data['created_by'] = $id;

        return Foodcategory::create($data);
    }

    public function updateFoodCategory(Request $request, $id)
    {
        $data = $request->all();
        $image = "";
        $foodcategory = $this->getSingleFoodCategory($id);
        if ($request->hasFile('food_category_image')) {
            $image = $this->uploadImage($request->file('food_category_image'), 'food_category');
        } else {
            $image = $foodcategory->food_category_image;
        }
        $id = Auth::user()->id;
        $data['food_category_image'] = $image;
        $data['updated_by'] = $id;
        $foodcategory->update($data);
        return $foodcategory;
    }

    public function getDataFoodCategory(Request $request)
    {
        $searchName = $request->query('search_name');

        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', array(1, 'asc'));


        $sortcolumns = array(
            0 => 'fs_food_category.food_category_name',
        );

        $query = Foodcategory::select('*');
        if (!empty($searchName)) {
            $query->where('food_category_name', 'like', '%' . $searchName . '%');
        }
        if (!empty($searchImage)) {
            $query->where('food_category_image', 'like', '%' . $searchImage . '%');
        }
        $recordstotal = $query->count();
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

        $foodcategory = $query->latest()->get();
        foreach ($foodcategory as $category) {
            $url = route("food-category.show", $category->id);
            $nameAction = $category->food_category_name != "" ? "<a href='" . $url . "'>" . $category->food_category_name . "</a>" : 'N/A';
            $Image = "<img src='" . url($category->food_category_image) . "' height='50px' width='50px'>";
            $json['data'][] = [
                $nameAction,
                $Image,
            ];
        }
        return $json;
    }

    public function getSingleFoodCategory($id)
    {
        return Foodcategory::findorfail($id);
    }

    public function destroyFoodCategory($id)
    {
        $foodcategory = $this->getSingleFoodCategory($id);

        if (File::exists($foodcategory->image)) {
            unlink("" . $foodcategory->image);
        }
        $foodcategory->delete();
        return $foodcategory;
    }
}
