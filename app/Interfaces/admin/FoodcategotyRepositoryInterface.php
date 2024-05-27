<?php

namespace App\Interfaces\admin;

use Illuminate\Http\Request;

interface FoodcategotyRepositoryInterface
{
    public function storeFoodCategory(Request $request);

    public function updateFoodCategory(Request $request, $id);

    public function destroyFoodCategory($id);

    public function getSingleFoodCategory($id);

    public function getDataFoodCategory(Request $request);

    public function getFoodCategorydata();
    public function getFoodCategorydataNew();
}
