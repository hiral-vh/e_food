<?php 

namespace App\Interfaces\admin;

use Illuminate\Http\Request;

interface UsercartRepositoryInterface {

    public function addCartdata(Request $request);
    public function addCartdataWithJosn($restaurant_id, $menu_id, $total_qty, $total_price);
    public function checkCartsamerestaurant(Request $request);
    public function checkCartsamerestaurantdata($restaurant_id);
    public function getUsercurrentCartdata($user_id);
    public function updateCartdata($totalQty, $totalPrice,$id,$remove_ingredientsData);
    public function checkCartData(Request $request);
    public function checkCartDataagain($restaurant_id, $menu_id);
    public function checkCartdataDelete($cart_id, $userid);
    public function getUserrecentTwoorder($restaurant_id);
    public function getOrderMenunames($order_id);
}