<?php

namespace App\Interfaces\admin;

use Illuminate\Http\Request;

interface MenuCategoryRepositoryInterface
{
    public function getMenuCategory();

    public function getAllMenuCategory();

    public function storeMenuCategory(Request $request);

    public function updateMenuCategory(Request $request, $id);

    public function destroyMenuCategory($id);

    public function getMenuCategoryTableData(Request $request);

    public function getSingleMenuCategory($id);
}
