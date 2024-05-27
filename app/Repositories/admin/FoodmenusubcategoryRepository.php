<?php

namespace App\Repositories\admin;

use App\Http\Traits\ApiResponseTrait;
use App\Interfaces\admin\FoodmenusubcategoryRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\admin\Cuisine;

class FoodmenusubcategoryRepository implements FoodmenusubcategoryRepositoryInterface
{
    public function getCuisindata()
    {
        return Cuisine::whereNull('deleted_at')->get();
    }
} 
