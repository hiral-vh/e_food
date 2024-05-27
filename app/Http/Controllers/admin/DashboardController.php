<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\StripeFunctionsTrait;
use App\Interfaces\admin\LoginRepositoryInterface;
use App\Models\admin\Ordermaster;
use App\Models\admin\Ownerpayment;
use App\Models\admin\Owner;
use App\Models\admin\Userbooktable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\admin\Ownerrecuringhistory;
use Hash;
use Illuminate\Support\Facades\Auth;
use Stripe\Order;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $loginRepository = "";
    use StripeFunctionsTrait;
    public function __construct(LoginRepositoryInterface $loginRepository)
    {
        $this->loginRepository = $loginRepository;
    }
    public function index()
    {
        $restarantId = Auth::user()->id;
       
        $startDate = date('Y-m-d H:i:s');
        $getEnddate = Ownerrecuringhistory::where('user_id', $restarantId)->whereNull('deleted_at')->orderBy('id', 'desc')->first();
        $day = '';
        if ($getEnddate) {
            $date1_ts = strtotime($startDate);
            $date2_ts = strtotime($getEnddate->end_date);
            $diff = $date2_ts - $date1_ts;
            $day =  round($diff / 86400);
        }
        $data['diffrenceDay'] = $day;
        $totalOrders = Ordermaster::where('restaurant_id', $restarantId)->where('order_status', '!=', 'Rejected Order');
        $totalSales = Ordermaster::where('restaurant_id', $restarantId)->where('order_status', 'Delivered')->sum('total_amount');
        $totalSalesCount = Ordermaster::where('restaurant_id', $restarantId)->where('order_status', 'Delivered');
        $totalBookingTableCount = Userbooktable::where('restaurant_id', $restarantId)->whereNull('deleted_at');
        $totalRemainigOrders = Owner::select('total_orders')->where('id',$restarantId)->first();

        

        $getTotalOrders = $this->loginRepository->getAllorders($restarantId);
        $getTotalTbales = $this->loginRepository->getTables($restarantId);
        $getUserbookTables = $this->loginRepository->getUserbooktableorder($restarantId);

        $totalMonthlyordersRev = $this->loginRepository->gettotalMonthlyordersRev($restarantId);

        $data['numberOfOrders'] = $totalOrders;
        $data['totalSales'] = $totalSales;
        $data['totalSalesCount'] = $totalSalesCount;
        $data['totalBooktabel'] = $getTotalTbales;
        $data['totalBookingTableCount'] = $totalBookingTableCount;
        $data['totaluserBooktabel'] = $getUserbookTables;
        $data['totalRemainingOrders'] = $totalRemainigOrders;

        return view('admin.dashboard', $data);
    }

    public function appusersList(Request $request)
    {
        return view('admin.appuser');
    }

    public function getAppuserlist(Request $request)
    {
        return $this->loginRepository->getAppuerList($request);
    }

    public function topup_orders(Request $request)
    {
        $total_order = $request->total_order;
        $total_days = $request->total_days;

        if ($total_order != '' && $total_days != '') {
            $restarantId = Auth::user()->id;
            $ownerData = Owner::find($restarantId);



            $insertArray = array(
                'owner_id' => $restarantId,
                'total_order' => $total_order,
                'total_days' => $total_days,
                'payment_type' => 'top_up',
                'created_at' => date('Y-m-d H:i:s')
            );
            $insert = new Ownerpayment($insertArray);
            $insert->save();
            $payment = $insert->id;

            return redirect()->route('makepaymentTopup', [$ownerData->id, $payment]);
        } else {
            Session::flash('error', 'Something went wrong');
            return redirect('restaurant-dashboard');
        }
    }
    public function makepaymentTopup($businessId, $businessStripeId)
    {
        return view('admin.make-paymenttopup', ['userId' => $businessId, 'paymentID' => $businessStripeId]);
    }
    public function createPaymentSessiontopup(Request $request)
    {
        $sessionId = $this->topAmountCustomer($request->user_id, $request->payment_id);
        return response()->json(['id' => $sessionId]);
    }

    public function paymentSuccessTopup($paymentId)
    {
        $restarantId = Auth::user()->id;
        $payment = Ownerpayment::find($paymentId);
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $paymentResponse = $stripe->checkout->sessions->retrieve(
            $payment->payment_request_id,
            []
        );

        $update = Ownerpayment::where('id', $paymentId)->update(array('payment_status' => $paymentResponse->payment_status, 'payment_date' => date('Y-m-d'), 'gateway_response' => $paymentResponse));
        $allowed_order = $payment->total_order;
        $updateUser = Owner::where('id', $restarantId)->update(array('total_orders' => $allowed_order));
        Session::flash('success', 'Orders Top Up successfully');
        return redirect('restaurant-dashboard');
    }
    public function paymentFailedTopup($paymentId)
    {
        $payment = Ownerpayment::find($paymentId);
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $paymentResponse = $stripe->checkout->sessions->retrieve(
            $payment->payment_request_id,
            []
        );

        $update = Ownerpayment::where('id', $paymentId)->update(array('payment_status' => $paymentResponse->payment_status, 'gateway_response' => $paymentResponse));
        Session::flash('error', 'Payment Failed');
        return redirect('restaurant-dashboard');
    }

    public function change_password()
    {
        return view('admin.change_password');
    }

    public function checkResturentpassword(Request $request)
    {
        $userpassword = auth()->guard('restaurantportal')->user()->password;
        if (!Hash::check(request('current_password'), $userpassword)) {
            echo 0;
        } else {
            echo 1;
        }
    }

    public function update_password(Request $request)
    {
        $update = $this->loginRepository->updateAdminpassword($request);
        if ($update) {
            Session::flash('success', 'Password update Successfully');
            return redirect()->route('change-password');
        } else {
            Session::flash('error', 'Something went wrong');
            return redirect()->route('change-password');
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function stripKeyUpdate(Request $request)
    {
        $update = Owner::where('id', Auth::user()->id)->update(['stripe_pk_key' => $request->strip_pk, 'stripe_sk_key' => $request->strip_sk, 'stripeflag' => '1']);

        if ($update) {
            Session::flash('success', 'Stripe key update Successfully');
            return redirect('profile');
        } else {
            Session::flash('error', 'Something went wrong');
            return redirect('profile');
        }
    }
    public function getMonthlyData(Request $request)
    {
       
        $searchType = $request['searchType'];
        $restaurantId = Auth::user()->id;
        if($request->listType == 'Bookings')
        {
            if($request->filter == 1){
             
                $getDate = explode('-',$request->dates);
                $fromDate = date('Y-m-d',strtotime($getDate[0]));
                $toDate = date('Y-m-d',strtotime($getDate[1]));
             
                for ($i=strtotime($fromDate); $i<=strtotime($toDate); $i+=86400) {  
                    $date = date("Y-m-d", $i);
                    $appointments = Userbooktable::whereDate('book_date','=',$date)->where('restaurant_id',$restaurantId)->count();
                    $finalArray[] = array('allDates' => date("d",strtotime($date)),"totalCount" => $appointments);
                } 
                return json_encode($finalArray);
            }
            if($searchType == 'Month')
            {
               
                for($i = 1; $i <=  date('t'); $i++)
                {
                    
                    $checkDate = date('Y') . "-" . date('m') . "-" . str_pad($i, 2, '0', STR_PAD_LEFT);
                    $bookings = Userbooktable::whereDate('book_date','=',$checkDate)->where('restaurant_id',$restaurantId)->count();
                    $finalArray[] = array('allDates' => date("d",strtotime($checkDate)),"totalCount" => $bookings);
                }
            
                return json_encode($finalArray);
            }
            else if($searchType=="week")
            {

                $checkDayDate = date("Y-m-d"); 
                $week = [];
                $carbaoDay = Carbon::createFromFormat('Y-m-d', $checkDayDate);
                for($i = 0; $i <= 6; $i++)
                {
                    $week = $carbaoDay->startOfWeek()->addDay($i)->format('Y-m-d');
                    $weekBookings = Userbooktable::whereDate('book_date','=',$week)->where('restaurant_id',$restaurantId)->count();
                    $finalArray[] = array('allDates' => date("d",strtotime($week)),"totalCount" => $weekBookings);
                }
                return json_encode($finalArray);
            }
            else
            {
                $checkDayDate = date("Y-m-d"); 
                $weekBookings = Userbooktable::whereDate('book_date','=',$checkDayDate)->where('restaurant_id',$restaurantId)->count();
                $finalArray[] = array('allDates' => date("d-m-y",strtotime($checkDayDate)),"totalCount" => $weekBookings);

                return json_encode($finalArray);
            }
        }
        if($request->listType == 'orders')
        {
            if($request->filter == '1'){
                $getDate = explode('-',$request->dates);
                $fromDate = date('Y-m-d',strtotime($getDate[0]));
                $toDate = date('Y-m-d',strtotime($getDate[1]));
                for ($i=strtotime($fromDate); $i<=strtotime($toDate); $i+=86400) {  
                    $date = date("Y-m-d", $i);
                    $appointments = Ordermaster::whereDate('order_date_time','=',$date)->where('restaurant_id',$restaurantId)->count();
                    $finalArray[] = array('allDates' => date("d",strtotime($date)),"totalCount" => $appointments);
                } 
                return json_encode($finalArray);
            }

            if($searchType == 'Month')
            {
                
                for($i = 1; $i <=  date('t'); $i++)
                {
                    
                    $checkDate = date('Y') . "-" . date('m') . "-" . str_pad($i, 2, '0', STR_PAD_LEFT);
                    $bookings = Ordermaster::whereDate('order_date_time','=',$checkDate)->where('restaurant_id',$restaurantId)->count();
                    $finalArray[] = array('allDates' => date("d",strtotime($checkDate)),"totalCount" => $bookings);
                }
             
                return json_encode($finalArray);
            }
            else if($searchType=="week")
            {

                $checkDayDate = date("Y-m-d"); 
                $week = [];
                $carbaoDay = Carbon::createFromFormat('Y-m-d', $checkDayDate);
                for($i = 0; $i <= 6; $i++)
                {
                    $week = $carbaoDay->startOfWeek()->addDay($i)->format('Y-m-d');
                    $weekBookings = Ordermaster::whereDate('order_date_time','=',$week)->where('restaurant_id',$restaurantId)->count();
                    $finalArray[] = array('allDates' => date("d",strtotime($week)),"totalCount" => $weekBookings);
                }
                return json_encode($finalArray);
            }
            else
            {
                $checkDayDate = date("Y-m-d"); 
                $weekBookings = Ordermaster::whereDate('order_date_time','=',$checkDayDate)->where('restaurant_id',$restaurantId)->count();
                $finalArray[] = array('allDates' => date("d-m-y",strtotime($checkDayDate)),"totalCount" => $weekBookings);

                return json_encode($finalArray);
            }
        }
    }
}
