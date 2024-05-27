<?php

namespace App\Interfaces\admin;

use Illuminate\Http\Request;

interface FoodmenucategoryRepositoryInterface
{
    public function getFoodMenuCategoryData();

    public function getFoodMenusubCategoryData($cid);

    public function getFoodMenusubCategoryDataAll();

    public function storeFoodMenuCategory(Request $request);

    public function updateFoodMenuCategory(Request $request, $id);

    public function destroyFoodMenuCategory($id);

    public function getSingleFoodMenuCategory($id);

    public function getDataFoodMenuCategory(Request $request);

    public function getMultipleFoodMenuCategory($id);
}
