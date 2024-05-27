<?php

namespace App\Interfaces\admin;

use Illuminate\Http\Request;

interface MenuRepositoryInterface
{
    public function getAllFoodMenu();

    public function getAllmenuSubcategorywise($id, $sub_category_id);

    public function getAllmenuAttribute($id, $menuid);

    public function getAllExtraItems($id, $menuid);

    public function getAllRemoveIngredients($id, $menuid);

    public function getMenubyIdwise($id);

    public function storeFoodMenu(Request $request);

    public function updateFoodMenu(Request $request, $id);

    public function destroyFoodMenu($id);

    public function getSingleFoodMenu($id);

    public function getSingleFoodMenuAttibute($id);

    public function getSingleFoodMenuExtraItem($id);

    public function getRemoveIngredients($id);

    public function getDataFoodMenu(Request $request);

    public function getMenuData();

    public function getUpdatedStatus(Request $request);

    public function getMenuCategory();

    public function getFoodMenusByName($name);

    public function getAllmenuMenuCategorywise($id, $menu_category_id);
}
