<?php

namespace App\Interfaces\admin;

use Illuminate\Http\Request;

interface OrdermasterRepositoryInterface
{

    public function storeOrder(Request $request, $orderItemjson);
    public function getOrderdataSearch(Request $request);
    public function updateOrderstatus(Request $request);
    public function updateOrderstatusreject(Request $request);
    public function getUsercurrentOrders($userid);
    public function getUserOrdershistory($userid);
    public function getUserOrdershistorybyOrderID($userid, $order_id);
    public function getUsercurrentOrdersbyID($userid, $orderid);
    public function orderStatushistory($userid, $orderid);
    public function orderItemByorderID($userid, $orderid);
    public function orderDataByorderID($userid, $orderid);
    public function orderDataDineinByorderID($userid);
    public function getOrderDetailByID($id);
    public function getOrderDetailByMenuItemID($id);
    public function CheckOrderstatus($booktableid, $userid);
    public function getOrderTabledetail($id);
    public function getnameIngrident($id);
}
