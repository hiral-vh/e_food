<?php

namespace App\Repositories\admin;

use App\Http\Traits\ApiResponseTrait;
use App\Interfaces\admin\SaveRestaurantRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\admin\Saverestaurant;

class SaveRestaurantRepository implements SaveRestaurantRepositoryInterface
{
    public function checkSavedornot($restaurant_id,$userid){
        return Saverestaurant::whereNull('deleted_at')->where('restaurant_id', $restaurant_id)->where('user_id', $userid)->first();
    }

    public function storesaverestaurant(Request $request)
    {
        $user = auth()->user();
        $insertArray = array(
            'restaurant_id' => $request->restaurant_id,
            'user_id' => $user['id'],
            'created_at' => date('Y-m-d H:i:s')
        );

        return Saverestaurant::create($insertArray);
    }
} 
