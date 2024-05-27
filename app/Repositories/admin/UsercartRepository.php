<?php

namespace App\Repositories\admin;

use App\Http\Traits\ApiResponseTrait;
use App\Interfaces\admin\UsercartRepositoryInterface;
use App\Models\admin\Usercart;
use App\Models\admin\Ordermaster;
use App\Models\admin\Orderitemmaster;
use Illuminate\Http\Request;
use DB;

class UsercartRepository implements UsercartRepositoryInterface
{
    public function checkCartData(Request $request){
        $user = auth()->user();
        return Usercart::where('user_id', $user['id'])->where('restaurant_id', $request->restaurant_id)->where('menu_id', $request->menu_id)->whereNull('deleted_at')->first();
    }
    public function checkCartdataDelete($cart_id, $userid){
        return Usercart::where('user_id', $userid)->where('id', $cart_id)->whereNull('deleted_at')->first();
    }
    public function checkCartDataagain($restaurant_id, $menu_id){
        $user = auth()->user();
        return Usercart::where('user_id', $user['id'])->where('restaurant_id', $restaurant_id)->where('menu_id', $menu_id)->whereNull('deleted_at')->first();
    }
    public function checkCartsamerestaurant(Request $request){
        $user = auth()->user();
        return Usercart::where('user_id', $user['id'])->whereNull('deleted_at')->first();
    }
    public function getOrderMenunames($order_id){
        $user = auth()->user();
        $query = Orderitemmaster::select('fs_order_item_master.*')
        ->with('menudatamulyiple:id,name')
            ->where('fs_order_item_master.user_id', $user['id'])
            ->where('fs_order_item_master.order_id', $order_id)
            ->whereNull('fs_order_item_master.deleted_at')
            ->get();
        return $query;
    }
    public function getUserrecentTwoorder($restaurantid){
        $user = auth()->user();
        return Ordermaster::select('id','user_id','restaurant_id','order_status','total_amount', 'order_date_time')->where('user_id',$user['id'])->where('restaurant_id', $restaurantid)->where(function($query){
            $query->where('order_status','Delivered')
                  ->orWhere('order_status','Order Collected');
        })->orderBy('id','desc')->skip(0)->take(2)->get();
    }
    public function getUsercurrentCartdata($userid){
        $query = Usercart::select('fs_user_cart_master.*')
            ->with('menudata:id,name,image,description')->where('fs_user_cart_master.user_id', $userid)
            ->whereNull('fs_user_cart_master.deleted_at')
            ->get();
        return $query;
    }
    public function checkCartsamerestaurantdata($restaurant_id){
        $user = auth()->user();
        return Usercart::select(DB::raw("SUM(item_qty) as qtysum"),DB::raw("SUM(item_price) as pricesum"))->where('user_id', $user['id'])->where('restaurant_id', $restaurant_id)->whereNull('deleted_at')->get();
    }
    public function updateCartdata($totalQty, $totalPrice, $id,$remove_ingredientsData){
        $user = auth()->user();
        $updateArray = array(
            'item_qty' => $totalQty,
            'item_price' => $totalPrice,
            'remove_ingredients' => $remove_ingredientsData,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $user['id']
        );
        return Usercart::where('id',$id)->update($updateArray);
    }
    public function addCartdata(Request $request)
    {
        $user = auth()->user();
        $insertArray = array(
            'user_id' => $user['id'],
            'restaurant_id' => $request->restaurant_id,
            'menu_id' => $request->menu_id,
            'item_qty' => $request->total_qty,
            'item_price' => $request->total_price,
            'remove_ingredients' => $request->remove_ingredients,
            'created_at' => date('Y-m-d H:i:s')
        );
        return Usercart::create($insertArray);
    }
    public function addCartdataWithJosn($restaurant_id, $menu_id, $total_qty, $total_price)
    {
        $user = auth()->user();
        $insertArray = array(
            'user_id' => $user['id'],
            'restaurant_id' => $restaurant_id,
            'menu_id' => $menu_id,
            'item_qty' => $total_qty,
            'item_price' => $total_price,
            'created_at' => date('Y-m-d H:i:s')
        );
        return Usercart::create($insertArray);
    }
}
