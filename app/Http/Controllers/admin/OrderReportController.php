<?php

namespace App\Http\Controllers\admin;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Interfaces\admin\FoodcategotyRepositoryInterface;
use App\Interfaces\admin\UserRepositoryInterface;
use App\Interfaces\admin\OrdermasterRepositoryInterface;
use App\Interfaces\admin\NotificationRepositoryInterface;
use App\Models\admin\Ordermaster;
use App\Models\admin\Owner;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class OrderReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $foodCategoryRepository = "", $userRepository = "", $ordermasterRepository = "", $notificationRepository = "";

    public function __construct(FoodcategotyRepositoryInterface $foodCategoryRepository, UserRepositoryInterface $userRepository, OrdermasterRepositoryInterface $ordermasterRepository, NotificationRepositoryInterface $notificationRepository)
    {
        $this->foodCategoryRepository = $foodCategoryRepository;
        $this->userRepository = $userRepository;
        $this->ordermasterRepository = $ordermasterRepository;
        $this->notificationRepository = $notificationRepository;
    }

    public function index()
    {
        $data['userData'] = $this->userRepository->getAlluser();
        return view('admin.order_report.index', $data);
    }

    public function getOrderdata(Request $request)
    {
        return $this->ordermasterRepository->getOrderdataSearch($request);
    }

    public function changeOrderstatus(Request $request)
    {
        $update =  $this->ordermasterRepository->updateOrderstatus($request);
        $orderData =  Ordermaster::select('*')->where('user_id', $request->userid)->where('id', $request->orderid)->whereNull('deleted_at')->first();
        if ($update) {
            // send notification to user book table
            $did = $request->userid;
            $title = 'Order Status';
            $msg = 'Your order is ' . $request->order_status . '. Order Number is #' . $orderData->order_number;
            $notifications = self::sendNotification($did, $title, $msg, '2');

            echo 1;
        } else {
            echo 0;
        }
    }

    public function acceptOrders(Request $request)
    {
        $update =  $this->ordermasterRepository->updateOrderstatus($request);
        $orderData =  Ordermaster::select('*')->where('user_id', $request->userid)->where('id', $request->orderid)->whereNull('deleted_at')->first();
        if ($update) {
            // send notification to user book table
            $did = $request->userid;
            $title = 'Order Status';
            $msg = 'Your order is Accepeted. Order Number is #' . $orderData->order_number;
            $notifications = self::sendNotification($did, $title, $msg, '2');
            echo 1;
        } else {
            echo 0;
        }
    }

    public function rejectOrderstatus(Request $request)
    {
        $update =  $this->ordermasterRepository->updateOrderstatusreject($request);
        $orderData =  Ordermaster::select('*')->where('user_id', $request->userid)->where('id', $request->orderid)->whereNull('deleted_at')->first();
        if ($update) {
            // send notification to user book table
            $did = $request->userid;
            $title = 'Order Status';
            $msg = 'Your order is Rejected. Order Number is #' . $orderData->order_number;

            $getRestroName = Owner::select('restaurant_name')->where('id',$orderData->restaurant_id)->first();
            $userTitle = 'Order Cancelled';
            $userMessage = $getRestroName->restaurant_name.' '."has cancelled your".' '.$orderData->order_number;
            $notifications = self::sendNotification($did, $title, $msg, '2');
            self::userSendNotification($did,$userTitle,$userMessage,'5');
            echo 1;
        } else {
            echo 0;
        }
    }


    public function show($id)
    {
        $orderData = $this->ordermasterRepository->getOrderDetailByID($id);
        $orderArray = array();
        if (count($orderData) > 0) {
            foreach ($orderData as $fkey) {
                $fkey->booktableuser = '';
                if ($fkey->book_table_id != '') {
                    $userBooktableData = $this->ordermasterRepository->getOrderTabledetail($fkey->book_table_id);
                    if ($userBooktableData) {
                        $fkey->booktableuser = $userBooktableData;
                    }
                }

                $fkey->orderItemData = $orderItemdata =  $this->ordermasterRepository->getOrderDetailByMenuItemID($id);
                $removeArray = array();
                if (count($orderItemdata) > 0) {
                    foreach ($orderItemdata as $key) {
                        if ($key->remove_ingredients != '') {
                            $key->getRemoveing = $this->ordermasterRepository->getnameIngrident($key->remove_ingredients);
                            $removeArray[] = $key;
                        }
                    }
                }
                $fkey->removeIngridence = $removeArray;


                $orderArray[] = $fkey;
            }
        }

        $data['orderData'] = $orderArray;

        return view('admin.order_report.show', $data);
    }


    public function create()
    {
    }
    public function store(Request $request)
    {
    }
    /* API Notification sent */
    public function sendNotification($userid, $title, $msg, $type = '')
    {

        $getDrivertoken = $this->userRepository->getByIddata($userid);
        date_default_timezone_set('UTC');
        $insarray = array(
            "user_id" => $userid,
            "notification_title" => $title,
            "notification_description" => $msg,
            "notification_type" => $type,
            "notification_datetime" =>  date('Y-m-d H:i:s'),
            "created_date" => date('Y-m-d H:i:s')
        );
        $insert = $this->notificationRepository->storeNotification($insarray);

        $NotificationData =  array('message' => $msg, 'body' => $msg, "title" => $title);
        if ($getDrivertoken) {
            NotificationHelper::pushToGoogle(array($getDrivertoken->device_token), $NotificationData);
        }
    }
    public function userSendNotification($userid, $title, $msg, $type = '')
    {
        $getDrivertoken = $this->userRepository->getByIddata($userid);
        date_default_timezone_set('UTC');
        $insarray = array(
            "user_id" => $userid,
            "notification_title" => $title,
            "notification_description" => $msg,
            "notification_type" => $type,
            "notification_datetime" =>  date('Y-m-d H:i:s'),
            "created_date" => date('Y-m-d H:i:s')
        );
        $insert = $this->notificationRepository->storeNotification($insarray);

        $NotificationData =  array('message' => $msg, 'body' => $msg, "title" => $title);
        if ($getDrivertoken) {
            NotificationHelper::pushToGoogle(array($getDrivertoken->device_token), $NotificationData);
        }
    }

}
