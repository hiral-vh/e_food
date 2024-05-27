<?php

namespace App\Repositories\admin;

use App\Http\Traits\ApiResponseTrait;
use App\Interfaces\admin\RecentlyvisitrestaurantRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\admin\Recentlyvisitrestaurant;

class RecentlyvisitrestaurantRepository implements RecentlyvisitrestaurantRepositoryInterface
{
    public function getLastvisitrestaurantbyuser($user_id)
    {
        return Recentlyvisitrestaurant::where('user_id', $user_id)->whereNull('deleted_at')->orderBy('id','desc')->get();
    }
}
