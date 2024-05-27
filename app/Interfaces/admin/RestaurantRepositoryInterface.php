<?php 

namespace App\Interfaces\admin;

use Illuminate\Http\Request;

interface RestaurantRepositoryInterface {
    public function storeRestaurantData(Request $request);

    public function updateRestaurantData(Request $request,$id);

    public function deleteRestaurant($id);

    public function getSingleRestaurantData($id);
    
    public function getRestaurantData(Request $request);
}