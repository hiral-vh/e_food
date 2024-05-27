<?php 

namespace App\Interfaces\admin;

use Illuminate\Http\Request;

interface RecentlyvisitrestaurantRepositoryInterface {
    public function getLastvisitrestaurantbyuser($user_id);
}