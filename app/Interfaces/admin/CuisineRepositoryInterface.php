<?php

namespace App\Interfaces\admin;

use Illuminate\Http\Request;

interface CuisineRepositoryInterface
{
    public function getCuisindata();

    public function getCuisindataByID($id);

    public function storeCuisine(Request $request);

    public function updateCuisine(Request $request, $id);

    public function destroyCuisine($id);

    public function getSingleCuisine($id);

    public function getCuisineTableData(Request $request);
}
