<?php

namespace App\Repositories\admin;

use App\Helpers\NotificationHelper;
use App\Http\Traits\ApiResponseTrait;
use App\Interfaces\admin\OrdermasterRepositoryInterface;
use App\Models\admin\Orderitemmaster;
use App\Models\admin\Ordermaster;
use App\Models\admin\Usercart;
use App\Models\admin\Orderstatushistory;
use App\Models\admin\Owner;
use App\Models\admin\RemoveIngredients;
use App\Models\admin\Usercarddetail;
use App\Models\admin\Userbooktable;
use Illuminate\Http\Request;
use Stripe;
use DB;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TotalOrderNotification;
use Carbon\Carbon;

class OrdermasterRepository implements OrdermasterRepositoryInterface
{
    public function getUsercurrentOrders($user_id)
    {
        return Ordermaster::select('id', 'estimated_min', 'order_number', 'restaurant_id', 'order_date_time')->where('user_id', $user_id)->whereIn('order_status', array('Order Confirmed', 'Preparing your Order', 'Your orders are on its way'))->whereNull('deleted_at')->orderBy('id', 'desc')->get();
    }
    public function getUserOrdershistory($user_id)
    {
        return Ordermaster::select('id', 'order_number', 'restaurant_id', 'order_date_time', 'order_number')->where('user_id', $user_id)->where('order_status', 'Delivered')->whereNull('deleted_at')->orderBy('id', 'desc')->get();
    }
    public function CheckOrderstatus($booktableid, $userid)
    {
        return Ordermaster::select('*')->where('book_table_id', $booktableid)->where('user_id', $userid)->where('order_status', 'Rejected Order')->whereNull('deleted_at')->get();
    }
    public function getUserOrdershistorybyOrderID($user_id, $id)
    {
        return Ordermaster::select('id', 'order_number', 'restaurant_id', 'order_date_time', 'order_number')->where('id', $id)->where('user_id', $user_id)->whereNull('deleted_at')->first();
    }
    public function orderDataByorderID($user_id, $order_id)
    {
        return Ordermaster::select('delivery_charge', 'discount_amount', 'sub_total', 'total_amount')->where('user_id', $user_id)->where('id', $order_id)->whereNull('deleted_at')->first();
    }
    public function orderDataDineinByorderID($user_id)
    {
        return Ordermaster::where('user_id', $user_id)->where('order_type', '2')->where('order_status', '!=', 'Rejected Order')->whereNull('deleted_at')->get();
    }
    public function getnameIngrident($id)
    {
        $newID = explode(',', $id);
        return RemoveIngredients::whereIn('id', $newID)->get();
    }
    public function getOrderTabledetail($booktableid)
    {
        $query = Userbooktable::select('fs_user_book_table.*')
            ->with('booktabletime:id,time_from,time_to', 'booktablename:id,table_name')
            ->where('id', $booktableid)
            ->whereNull('deleted_at')
            ->first();
        return $query;
    }
    public function getOrderDetailByMenuItemID($id)
    {
        $query = Orderitemmaster::select('fs_order_item_master.*')
            ->with('menudata:id,name,image,description,price')
            ->where('fs_order_item_master.order_id', $id)
            ->whereNull('fs_order_item_master.deleted_at')
            ->get();
        return $query;
    }
    public function getOrderDetailByID($id)
    {
        $restaurantId = auth()->guard('restaurantportal')->user()->id;
        $query = Ordermaster::select('fs_order_master.*', 'fs_user.first_name', 'fs_user.last_name', 'fs_user.email', 'fs_user.country_code', 'fs_user.mobile_no', 'fs_user_delivery_address.address_line', 'fs_user_delivery_address.address_street', 'fs_user_delivery_address.address_city', 'fs_user_delivery_address.address_postcode', 'fs_user_delivery_address.address_country_code', 'fs_user_delivery_address.address_contact_no', 'fs_delivery_person.delivery_person_name')
            ->leftJoin('fs_user', 'fs_order_master.user_id', '=', 'fs_user.id')
            ->leftJoin('fs_user_delivery_address', 'fs_order_master.delivery_id', '=', 'fs_user_delivery_address.id')
            ->leftJoin('fs_delivery_person', 'fs_order_master.delivery_person_id', '=', 'fs_delivery_person.id')
            ->where('fs_order_master.restaurant_id', $restaurantId)
            ->where('fs_order_master.id', $id)
            ->whereNull('fs_order_master.deleted_at')
            ->get();
        return $query;
    }

    public function getOrderdataSearch($request)
    {
        $restaurantId = auth()->guard('restaurantportal')->user()->id;
        $search_user = $request->query('search_user');
        $search_ordertype = $request->query('search_ordertype');
        // $search_orderstatus = $request->query('search_orderstatus');
        $search_name = $request->query('search_name');
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');

        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', array(1, 'asc'));


        $sortcolumns = array(
            0 => 'fs_order_master.id',
            1 => 'fs_order_master.user_id',
            2 => 'fs_order_master.order_type',
            3 => 'fs_order_master.order_date_time',
            4 => 'fs_order_master.order_number',
            5 => 'fs_order_master.delivery_charge',
            6 => 'fs_order_master.total_amount',
        );

        $query = Ordermaster::select('fs_order_master.*', 'fs_user.first_name', 'fs_user.last_name')
            ->leftJoin('fs_user', 'fs_order_master.user_id', '=', 'fs_user.id')
            ->where('fs_order_master.restaurant_id', $restaurantId)
            ->orderBy('fs_order_master.id', 'DESC');
        if (!empty($search_user)) {
            $query->where('fs_order_master.user_id', $search_user);
        }
        if (!empty($search_ordertype)) {
            $query->where('fs_order_master.order_type',   $search_ordertype);
        }
        if (!empty($search_name)) {
            $query->where('fs_order_master.order_number', $search_name);
        }
        if ($start_date != '' && $end_date != '') {
            $start_date = $start_date . ' 00:00:00';
            $end_date = $end_date . ' 23:59:59';
            $query->whereBetween('fs_order_master.order_date_time', ["$start_date", "$end_date"]);
        }


        $recordstotal = $query->count();
        $sortColumnName = $sortcolumns[$order[0]['column']];

        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $json = array(
            'draw' => $draw,
            'recordsTotal' => $recordstotal,
            'recordsFiltered' => $recordstotal,
            'data' => [],
        );

        $foodcategory = $query->latest()->get();
        $no = 1;
        foreach ($foodcategory as $category) {
            $url = route("order-report.show", $category->id);
            $orderType = '';
            $deliveryCharge = '';
            if ($category->order_type == '1') {
                $orderType = 'Collection';
            } else if ($category->order_type == '2') {
                $orderType = 'Dine-in';
            } else if ($category->order_type == '3') {
                $orderType = 'Delivery';
            }

            if($category->delivery_charge == '0.00')
            {
                $deliveryCharge = '-';
            }
            else if($category->delivery_charge == null)
            {
                $deliveryCharge = '-';
            }
            else
            {
                $deliveryCharge = '&#163;'.$category->delivery_charge;
            }
            $nameAction = $category->order_number != "" ? "<a href='" . $url . "'>" . $category->order_number . "</a>" : 'N/A';
            $json['data'][] = [
                $no,
                $category->first_name . ' ' . $category->last_name,
                $orderType,
                date("d/m/Y h:i A", strtotime($category->order_date_time)),
                $nameAction,
                $deliveryCharge,
                '&#163;'. $category->total_amount

            ];
            $no++;
        }
        return $json;
    }

    public function orderItemByorderID($user_id, $order_id)
    {
        $query = Orderitemmaster::select('fs_order_item_master.*')
            ->with('menudata:id,name')
            ->where('fs_order_item_master.user_id', $user_id)
            ->where('fs_order_item_master.order_id', $order_id)
            ->whereNull('fs_order_item_master.deleted_at')
            ->get();
        return $query;
    }
    public function getUsercurrentOrdersbyID($user_id, $order_id)
    {
        return Ordermaster::select('id', 'estimated_min', 'order_number', 'restaurant_id', 'order_date_time')->where('id', $order_id)->where('user_id', $user_id)->whereIn('order_status', array('Order Confirmed', 'Preparing your Order', 'Your orders are on its way'))->whereNull('deleted_at')->first();
    }
    public function orderStatushistory($user_id, $order_id)
    {
        return Orderstatushistory::where('user_id', $user_id)->where('order_id', $order_id)->whereNull('deleted_at')->orderBy('id', 'asc')->get();
    }
    public function updateOrderstatus($request)
    {
        $updateArray = array(
            'order_status' => $request->order_status,
            'updated_at' => date('Y-m-d H:i:s')
        );
        $update = Ordermaster::where('id', $request->orderid)->update($updateArray);
        $insertstatusArray = array(
            'user_id' => $request->userid,
            'order_id' => $request->orderid,
            'order_status' => $request->order_status,
            'created_at' => date('Y-m-d H:i:s')
        );
        $insertstautus = Orderstatushistory::create($insertstatusArray);



        return $update;
    }
    public function updateOrderstatusreject($request)
    {
        $updateArray = array(
            'order_status' => 'Rejected Order',
            'reject_order_reason' => $request->reject_reason,
            'updated_at' => date('Y-m-d H:i:s')
        );
        $update = Ordermaster::where('id', $request->orderid)->update($updateArray);
        $insertstatusArray = array(
            'user_id' => $request->userid,
            'order_id' => $request->orderid,
            'order_status' => 'Rejected Order',
            'created_at' => date('Y-m-d H:i:s')
        );
        $insertstautus = Orderstatushistory::create($insertstatusArray);

        $getOrderNo = Ordermaster::where('id',$request->orderid)->first();
        $getRestroName = Owner::select('restaurant_name')->where('id',$getOrderNo->restaurant_id)->first();
        $title = 'Order Cancelled';
        $msg = $getRestroName->restaurant_name.' '."has cancelled your".' '.$getOrderNo->order_number;
        self::sendNotification($request->userid,$title,$msg,'5');

        return $update;
    }
    public function storeOrder($request, $orderItemjson)
    {
        $user = auth()->user();
        $randomNo = substr(str_shuffle("0123456789"), 0, 4);
        $order_number = date('Ymdhis') . $randomNo;
        $getCustomerstripID = Usercarddetail::where('id', $request->payment_id)->whereNull('deleted_at')->first();
        if (!$getCustomerstripID) {
            return '0';
        }
        $getOwnerStripeID = Owner::find($request->restaurant_id);
        if ($getOwnerStripeID->stripe_sk_key != '') {
            $stripKey = $getOwnerStripeID->stripe_sk_key;
        } else {
            $stripKey = env('STRIPE_SECRET');
        }
        // stripe code to cut payment
        Stripe\Stripe::setApiKey($stripKey);
        $stripe = new \Stripe\StripeClient($stripKey);
        $currency = "EUR";
        $itemName = "Order Payment";
        $itemNumber = $order_number;
        $itemPrice = $request->total_amount * 100;
        $charge = \Stripe\Charge::create(array(
            'customer' => $getCustomerstripID->stripe_customer_id,
            'amount' => $itemPrice,
            'currency' => $currency,
            'description' => $itemNumber,
            'metadata' => array(
                'item_id' => $itemNumber
            )
        ));
        $chargeJson = $charge->jsonSerialize();
        if ($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1 && $chargeJson['status'] == 'succeeded') {
            $insertArray = array(
                'user_id' => $user['id'],
                'restaurant_id' => $request->restaurant_id,
                'delivery_id' => $request->delivery_id,
                'payment_id' => $request->payment_id,
                'discount_amount' => $request->discount,
                'coupon_code' => $request->coupon_code,
                'discount_id' => $request->discount_id,
                'order_type' => $request->order_type,
                'book_table_id' => $request->book_table_id,
                'estimated_min' => $request->estimated_min,
                'delivery_charge' => $request->delivery_charge,
                'sub_total' => $request->sub_total,
                'total_amount' => $request->total_amount,
                'order_status' => 'Order Confirmed',
                'order_number' => $order_number,
                'order_payment_json' => json_encode($chargeJson),
                'order_date_time' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s')
            );
            $insert = Ordermaster::create($insertArray);

            //notification
            $details = [
                "type" => 2,
                "orderId" => $insert['id'],
                "userName" => $user['first_name'] . ' ' . $user['last_name'],
                "message" => 'has placed a new order.',
                "date&time" => Carbon::now(),
            ];

            Notification::send($getOwnerStripeID, new TotalOrderNotification($details));
            //end

            // add order history data

            $insertstatusArray = array(
                'user_id' => $user['id'],
                'order_id' => $insert['id'],
                'order_status' => 'Order Confirmed',
                'created_at' => date('Y-m-d H:i:s')
            );
            $insertstautus = Orderstatushistory::create($insertstatusArray);

            $getOrderNo = Ordermaster::select('order_number')->where('id',$insert['id'])->first();
            $getRestroName = Owner::select('restaurant_name')->where('id',$insert['restaurant_id'])->first();
            $title = 'Order Confirmed';
            $msg = $getRestroName->restaurant_name.' '."has confirmed your".' '.$getOrderNo->order_number;
            self::sendNotification($user['id'],$title,$msg,'4');






            if (count($orderItemjson) > 0) {
                foreach ($orderItemjson as $okey) {

                    // remove cart data
                    $deleteCart = Usercart::where('id', $okey['cart_id'])->delete();

                    $insertItemArray = array(
                        'order_id' => $insert['id'],
                        'user_id' => $user['id'],
                        'restaurant_id' => $request->restaurant_id,
                        'menu_id' => $okey['menu_id'],
                        'item_qty' => $okey['item_qty'],
                        'remove_ingredients' => $okey['remove_ingredients'],
                        'extra_item' => isset($okey['extra_item']) ? $okey['extra_item'] :'',
                        'item_price' => $okey['item_price'],
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    $insertItem = Orderitemmaster::create($insertItemArray);
                }
            }
            return $insert;
        } else {
            return '0';
        }
    }
    public function userSendNotification($userid, $title, $msg, $type = '')
    {

        $insarray = array(
            "user_id" => $userid,
            "notification_title" => $title,
            "notification_description" => $msg,
            "notification_type" => $type,
            "notification_datetime" =>  date('Y-m-d H:i:s'),
            "created_date" => date('Y-m-d H:i:s')
        );
        $insert = $this->notificationRepository->storeNotification($insarray);

        $NotificationData =  array('message' => $msg, 'body' => $msg, "title" => $title, "user_book_table_id" => $user_book_table_id);
        if ($getDrivertoken) {
            NotificationHelper::pushToGoogle(array($getDrivertoken->device_token), $NotificationData);
        }
    }
    public function sendNotification($title,$body,$icon)
    {

        $firebaseToken = Owner::whereNotNull('device_token')->pluck('device_token')->all();

        $SERVER_API_KEY = 'AAAAoPv4xeE:APA91bHmn0W0NgaTjc5IH3W__56V9co7xnP00ENYrKSXT1aSiJOPEUtinxDMGWP4xfLWMo-F0vGr_IRaR2OSFuupqcGfwhjWwCsakDO_WSpSVLpZnGE9B0CJuRiaJUub1t8w1OFvsZXW';


        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $title,
                "body" => $body,
                "icon" => $icon,
            ]
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        return $response;
    }
}
