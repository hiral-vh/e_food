<?php 

namespace App\Interfaces\admin;

use Illuminate\Http\Request;

interface SaveRestaurantRepositoryInterface {
    public function checkSavedornot($restaurant_id, $userid);
    public function storesaverestaurant(Request $request);
}