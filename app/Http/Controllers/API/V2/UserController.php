<?php

namespace App\Http\Controllers\API\V2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\UserHelper;
use App\Helpers\MailHelper;
use App\Helpers\NotificationHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Mail;
use Stripe;
use App\Mail\SendMailable;
use App\Models\admin\User;
use App\Models\admin\Userdeliveryaddress;
use App\Models\admin\Userbooktable;
use App\Models\admin\Usercarddetail;
use App\Models\admin\Notification;
use App\Models\admin\Ordermaster;
use App\Interfaces\admin\CountryRepositoryInterface;
use App\Interfaces\admin\UserRepositoryInterface;
use App\Interfaces\admin\FoodcategotyRepositoryInterface;
use App\Interfaces\admin\RecentlyvisitrestaurantRepositoryInterface;
use App\Interfaces\admin\LoginRepositoryInterface;
use App\Interfaces\admin\SaveRestaurantRepositoryInterface;
use App\Interfaces\admin\CuisineRepositoryInterface;
use App\Interfaces\admin\BookTableRepositoryInterface;
use App\Interfaces\admin\UserbooktableRepositoryInterface;
use App\Interfaces\admin\FoodmenucategoryRepositoryInterface;
use App\Interfaces\admin\MenuRepositoryInterface;
use App\Interfaces\admin\UsercartRepositoryInterface;
use App\Interfaces\admin\OrdermasterRepositoryInterface;
use App\Interfaces\admin\NotificationRepositoryInterface;
use App\Interfaces\admin\DiscountRepositoryInterface;
use App\Interfaces\admin\MenuCategoryRepositoryInterface;
use App\Models\admin\Owner;
use App\Models\admin\Usercart;

class UserController extends Controller
{
    public $successStatus = 200;
    protected $countryRepository = '', $userRepository = '', $foodcategotyRepository = '', $recentlyvisitrestaurantRepository = '', $loginRepository = '', $saverestaurantRepository = '', $cuisineRepository = '', $booktableRepository = '', $userbooktableRepository = '', $foodmenucategoryRepository = '', $menuRepository = '', $usercartRepository = '', $ordermasterRepository = '', $notificationRepository = '', $discountRepository = '', $menuCategoryRepository = '';
    public function __construct(CountryRepositoryInterface $countryRepository, UserRepositoryInterface $userRepository, FoodcategotyRepositoryInterface $foodcategotyRepository, RecentlyvisitrestaurantRepositoryInterface $recentlyvisitrestaurantRepository,  LoginRepositoryInterface $loginRepository,  SaveRestaurantRepositoryInterface $saverestaurantRepository,  CuisineRepositoryInterface $cuisineRepository,  BookTableRepositoryInterface $booktableRepository,  UserbooktableRepositoryInterface $userbooktableRepository,  FoodmenucategoryRepositoryInterface $foodmenucategoryRepository,  MenuRepositoryInterface $menuRepository, UsercartRepositoryInterface $usercartRepository, OrdermasterRepositoryInterface $ordermasterRepository, NotificationRepositoryInterface $notificationRepository, DiscountRepositoryInterface $discountRepository, MenuCategoryRepositoryInterface $menuCategoryRepository)
    {
        // self::app_tarce();
        $this->menuCategoryRepository = $menuCategoryRepository;
        $this->countryRepository = $countryRepository;
        $this->userRepository = $userRepository;
        $this->foodcategotyRepository = $foodcategotyRepository;
        $this->recentlyvisitrestaurantRepository = $recentlyvisitrestaurantRepository;
        $this->loginRepository = $loginRepository;
        $this->saverestaurantRepository = $saverestaurantRepository;
        $this->cuisineRepository = $cuisineRepository;
        $this->booktableRepository = $booktableRepository;
        $this->userbooktableRepository = $userbooktableRepository;
        $this->foodmenucategoryRepository = $foodmenucategoryRepository;
        $this->menuRepository = $menuRepository;
        $this->usercartRepository = $usercartRepository;
        $this->ordermasterRepository = $ordermasterRepository;
        $this->notificationRepository = $notificationRepository;
        $this->discountRepository = $discountRepository;
    }
    public static function app_tarce()
    {
        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $ipaddress = $_SERVER['REMOTE_ADDR'];
        $page = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}";
        if (!empty($_SERVER['QUERY_STRING'])) {
            $page = $_SERVER['QUERY_STRING'];
        } else {
            $page = "";
        }
        if (!empty($_POST)) {
            $user_post_data = $_POST;
        } else {
            $user_post_data = array();
        }
        $user_post_data = json_encode($user_post_data);
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        $remotehost = @getHostByAddr($ipaddress);
        $user_info = json_encode(array(
            "Ip" => $ipaddress,
            "Page" => $page,
            "UserAgent" => $useragent,
            "RemoteHost" => $remotehost
        ));
        $user_track_data = array(
            "url" => $actual_link,
            "user_details" => $user_info,
            "data" => $user_post_data,
            "createddate" => date('Y-m-d H:i:s'),
            "type" => "service"
        );
        DB::table('fs_user_track')->insert($user_track_data);
    }
    public function test()
    {
        echo 'dipali';
    }
    public function testnotification()
    {
        $user = auth()->user();
        $did = $user['id'];
        $title = 'Dipali Check Test';
        $msg = 'test notification send.';
        $notifications = self::sendNotification($did, $title, $msg, '1', '');
    }
    public function convertString($user)
    {
        $modelAsArray = $user;
        if (!is_array($user)) {
            $modelAsArray = $user->toArray();
        }
        array_walk_recursive($modelAsArray, function (&$item, $key) {
            $item = $item === null ? '' : $item;
        });
        return $modelAsArray;
    }
    /* API Country List */
    public function countryList(Request $request)
    {
        $countryData =  $this->countryRepository->getCountry();
        if (count($countryData) != 0) {
            return response()->json(['error_msg' => 'Country List.', 'status' => 1, 'data' => $countryData], $this->successStatus);
        } else {
            return response()->json(['error_msg' => 'Something went wrong.', 'data' => array(), 'status' => 0], $this->successStatus);
        }
    }

    /* Register API */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'country_code' => 'required',
            'mobile_no' => 'required',
            'email' => 'required|email',
            'password' => 'required|same:retype_password',
            'retype_password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0], 'status' => 0], 200);
        } else {
            $checkEmailexist = $this->userRepository->checkEmailuser($request->email);
            if ($checkEmailexist) {
                return response()->json(['error_msg' => 'Email already exist.', 'data' => array(), 'status' => 0], $this->successStatus);
            }

            $insert = $this->userRepository->storeUser($request);
            config(['auth.guards.api.provider' => 'web']);
            $credentials = array('email' => $request->email, 'password' => $request->password);
            if (Auth::guard('web')->attempt($credentials)) {
                $accessToken = auth()->guard('web')->user()->createToken('authToken')->plainTextToken;
                $update = User::updateUser($insert->id, array("remember_token" => $accessToken));
                $user = auth()->guard('web')->user();
            }

            $userDetails = User::find($insert->id);
            return response()->json(['error_msg' => 'Register Successfully.', 'status' => 1, 'data' => array($userDetails)], $this->successStatus);
        }
    }
    /* Login API */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0], 'status' => 0], 200);
        } else {
            config(['auth.guards.api.provider' => 'web']);

            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
            if (Auth::guard('web')->attempt($credentials)) {
                $user = auth()->guard('web')->user();
                $accessToken = auth()->guard('web')->user()->createToken('authToken')->plainTextToken;
                $user->remember_token = $accessToken;
                if ($request->device_token != '') {
                    $user->device_token = $request->device_token;
                }

                $user->save();
                $user = auth()->guard('web')->user();
                return response()->json(['error_msg' => 'You have been successfully logged in.', 'data' => array($user), 'status' => 1], $this->successStatus);
            } else {
                return response()->json(['error_msg' => 'Email or Password is incorrect.', 'data' => array(), 'status' => 0], $this->successStatus);
            }
        }
    }
    /* API  Forgot password */
    public function forgot_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0], 'status' => 0], 200);
        } else {
            $checkEmail = $this->userRepository->checkEmailuser($request->email);
            if ($checkEmail) {
                $randOTP = substr(str_shuffle("0123456789"), 0, 5);
                $updateArray = array(
                    'otp' => $randOTP,
                    'updated_at' => date('Y-m-d H:i:s')
                );
                $update = User::updateUser($checkEmail->id, $updateArray);

                $html = '<p>Please use the verification code below on the Food Services:</p>
                <p style="text-align:center;font-size:18px;"><b>' . $randOTP . '</b></p><p>If you didn\'t request this, you can ignore this email or let us know.</p>';

                $subject = __('emails.otp_email');
                $BODY = __('emails.otp_email_body', ['USERNAME' => $checkEmail->first_name . ' ' . $checkEmail->last_name, 'HTMLTABLE' => $html]);
                $body_email = __('emails.template', ['BODYCONTENT' => $BODY]);


                $mail = MailHelper::mail_send($body_email, $request->email, $subject);

                return response()->json(['error_msg' => 'OTP sent your registered email address please check.', 'status' => 1, 'data' => array("id" => $checkEmail->id)], $this->successStatus);
            } else {
                return response()->json(['error_msg' => 'Email not found.', 'data' => array(), 'status' => 0], $this->successStatus);
            }
        }
    }
    /* API Verify OTP */
    public function verifyOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required|numeric',
            'id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0], 'status' => 0], 200);
        } else {
            $checkOtpverify =  $this->userRepository->checkForgotOTPverify($request->id, $request->otp);
            if ($checkOtpverify || $request->otp == '99999') {
                $updateArray = array(
                    'otp' => null,
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $update = User::updateUser($request->id, $updateArray);
                if ($update) {
                    return response()->json(['error_msg' => 'OTP verify successfully.', 'status' => 1, 'data' => array()], $this->successStatus);
                } else {
                    return response()->json(['error_msg' => 'Something went wrong.', 'data' => array(), 'status' => 0], $this->successStatus);
                }
            } else {
                return response()->json(['error_msg' => 'Invalid otp.Please try again.', 'data' => array(), 'status' => 0], $this->successStatus);
            }
        }
    }
    /* API  Set New password */
    public function set_new_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'password' => 'required|same:retype_password',
            'retype_password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0], 'status' => 0], 200);
        } else {
            $updateArray = array(
                'password' => Hash::make($request->password),
                'updated_at' => date('Y-m-d H:i:s')
            );
            $update = User::updateUser($request->id, $updateArray);
            if ($update) {
                return response()->json(['error_msg' => 'Set password successfully.', 'status' => 1, 'data' => array()], $this->successStatus);
            } else {
                return response()->json(['error_msg' => 'Something went wrong.', 'data' => array(), 'status' => 0], $this->successStatus);
            }
        }
    }
    /* API  Dashboard API */
    public function user_dashboard(Request $request)
    {
        $user = auth()->user();
        $live_lattitude = $request->live_latitude;
        $live_longitude = $request->live_longitude;

        $getFoodCategory = $this->foodcategotyRepository->getFoodCategorydata();

        $recentlyVisitrestaurant = $this->recentlyvisitrestaurantRepository->getLastvisitrestaurantbyuser($user['id']);
        $restuarantvisitArray = array();


        if (count($recentlyVisitrestaurant) > 0) {
            foreach ($recentlyVisitrestaurant as $key) {
                $getRestaurantDetail = $this->loginRepository->getRestaurantDetailbyRestaurant($key->restaurant_id);
                if (count($getRestaurantDetail) > 0) {
                    foreach ($getRestaurantDetail as $rkey) {
                        $unit = 'kilometers';
                        $rkey->distance = self::getDistanceBetweenPointsNew($live_lattitude, $live_longitude, $rkey->restaurant_latitude, $rkey->restaurant_longitude, $unit);
                        $saverestaurant = $this->saverestaurantRepository->checkSavedornot($rkey->id, $user['id']);
                        $rkey->save_restaurant = '0';
                        if ($saverestaurant) {
                            $rkey->save_restaurant = '1';
                        }
                        $restuarantvisitArray[] = $rkey;
                    }
                }
            }
        }



        $restaurantNearbyyou = $this->loginRepository->getRestaurantDetailnearYou($live_lattitude, $live_longitude, $distance = 5000);


        $nearBYyouArray = array();
        if (count($restaurantNearbyyou) > 0) {
            foreach ($restaurantNearbyyou as $nkey) {
                $saverestaurant = $this->saverestaurantRepository->checkSavedornot($nkey->id, $user['id']);
                $nkey->save_restaurant = '0';
                if ($saverestaurant) {
                    $nkey->save_restaurant = '1';
                }
                $nearBYyouArray[] = $nkey;
            }
        }

        $allrestaurant = array();
        $mainArray = array('food_category' => $getFoodCategory, 'recentky_visit' => $restuarantvisitArray, 'restaurant_near_by_you' => $nearBYyouArray, 'all_restaurant' => $allrestaurant);
        return response()->json(['error_msg' => 'Dashboard data.', 'status' => 1, 'data' => $mainArray], $this->successStatus);
    }
    /* API  Save Restaurant API */
    public function save_restaurant(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'restaurant_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0], 'status' => 0], 200);
        } else {
            $totalOrders = Owner::find($request->restaurant_id);
            if ($totalOrders) {
                if ($totalOrders->total_orders <= 0) {
                    return response()->json(['error_msg' => 'Restaurant is deactivated.', 'data' => array(), 'status' => 0], $this->successStatus);
                    die();
                }
            }

            $checkAlreadysave = $this->saverestaurantRepository->checkSavedornot($request->restaurant_id, $user['id']);
            if ($checkAlreadysave) {
                return response()->json(['error_msg' => 'Already save the restaurant.', 'data' => array(), 'status' => 0], $this->successStatus);
            } else {
                $insert = $this->saverestaurantRepository->storesaverestaurant($request);
                if ($insert) {
                    return response()->json(['error_msg' => 'Restaurant saved successfully.', 'status' => 1, 'data' => array()], $this->successStatus);
                } else {
                    return response()->json(['error_msg' => 'Something went wrong.', 'data' => array(), 'status' => 0], $this->successStatus);
                }
            }
        }
    }
    /*  Cuisine data */
    public function cuisine_data(Request $request)
    {
        $cuisineData =  $this->cuisineRepository->getCuisindata();
        if (count($cuisineData) != 0) {
            return response()->json(['error_msg' => 'Cuisine List.', 'status' => 1, 'data' => $cuisineData], $this->successStatus);
        } else {
            return response()->json(['error_msg' => 'Something went wrong.', 'data' => array(), 'status' => 0], $this->successStatus);
        }
    }
    /*  Filter Restaurant */
    public function filter_restaurant(Request $request)
    {
        $user = auth()->user();
        $live_lattitude = $request->live_latitude;
        $live_longitude = $request->live_longitude;
        $cuisine_id = $request->cuisine_id;
        $price = $request->price;
        // $food_type = $request->food_type;
        $categoryId = $request->food_type;
        $distance = $request->distance;
        if ($distance == '') {
            $distance = 10000000;
        } else if ($distance == 'auto') {
            $distance = 10000000;
        } else {
            $distance = $distance;
        }

        /*if($food_type !=''){
            $restaurantNearbyyou = $this->loginRepository->getResturentByfoodType($live_lattitude, $live_longitude, $food_type, $distance);
        }else{
            $restaurantNearbyyou = $this->loginRepository->getRestaurantDetailByfilter($live_lattitude, $live_longitude, $cuisine_id, $price, $distance);
        }*/

        if ($categoryId != '') {
            $restaurantNearbyyou = $this->loginRepository->getResturentByfoodType($live_lattitude, $live_longitude, $categoryId, $distance);
        } else {
            $restaurantNearbyyou = $this->loginRepository->getRestaurantDetailByfilter($live_lattitude, $live_longitude, $cuisine_id, $price, $distance);
        }



        $allrestaurant = array();
        if (count($restaurantNearbyyou) > 0) {
            foreach ($restaurantNearbyyou as $nkey) {
                $saverestaurant = $this->saverestaurantRepository->checkSavedornot($nkey->id, $user['id']);
                $nkey->save_restaurant = '0';
                if ($saverestaurant) {
                    $nkey->save_restaurant = '1';
                }
                $allrestaurant[] = $nkey;
            }
        }

        $mainArray = array('food_category' => array(), 'recentky_visit' => array(), 'restaurant_near_by_you' => array(), 'all_restaurant' => $allrestaurant);
        return response()->json(['error_msg' => 'Restaurant data.', 'status' => 1, 'data' => $mainArray], $this->successStatus);
    }

    /*  Venue List */
    public function venue_list(Request $request)
    {
        $user = auth()->user();
        $search_venue = $request->search_venue;

        $getsearch_venuesuggestion = $this->loginRepository->getAllvenueseachbyName($search_venue);
        $searchVenueArray = array();
        if ($search_venue != '') {
            if (count($getsearch_venuesuggestion) > 0) {
                foreach ($getsearch_venuesuggestion as $vkey) {
                    $getrestaurentBooktablelist = $this->booktableRepository->getTableList($vkey->id);
                    $moreTableArray = array();
                    if (count($getrestaurentBooktablelist) > 0) {
                        foreach ($getrestaurentBooktablelist as $rkey) {
                            $moreTableArray[] = $rkey;
                        }
                    }
                    $vkey->restaurent_table = $moreTableArray;
                    $searchVenueArray[] = $vkey;
                }
            }
        }


        $alldata = $this->loginRepository->getAllvenue();
        $allVenuearray = array();
        if (count($alldata) > 0) {
            foreach ($alldata as $akey) {
                $getrestaurentBooktablelist = $this->booktableRepository->getTableList($akey->id);
                $morevenueTableArray = array();
                if (count($getrestaurentBooktablelist) > 0) {
                    foreach ($getrestaurentBooktablelist as $rkey) {
                        $morevenueTableArray[] = $rkey;
                    }
                }
                $akey->restaurent_table = $morevenueTableArray;
                $allVenuearray[] = $akey;
            }
        }

        $venueArray = array('suggestion_data' => $searchVenueArray, 'all_data' => $allVenuearray);
        return response()->json(['error_msg' => 'Venue data.', 'status' => 1, 'data' => $venueArray], $this->successStatus);
    }
    /*  Restaurant Table List */
    public function restaurant_table_list(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'restaurant_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0], 'status' => 0], 200);
        } else {
            $totalOrders = Owner::find($request->restaurant_id);
            if ($totalOrders) {
                if ($totalOrders->total_orders <= 0) {
                    return response()->json(['error_msg' => 'Restaurant is deactivated.', 'data' => array(), 'status' => 0], $this->successStatus);
                    die();
                }
            }


            $getrestaurentBooktablelist = $this->booktableRepository->getTableList($request->restaurant_id);
            if (count($getrestaurentBooktablelist) > 0) {
                return response()->json(['error_msg' => 'Restaurant table data.', 'status' => 1, 'data' => $getrestaurentBooktablelist], $this->successStatus);
            }
            return response()->json(['error_msg' => 'No data found.', 'data' => array(), 'status' => 0], $this->successStatus);
        }
    }
    /*  Restaurant Duration List */
    public function restaurant_table_duration_list(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'book_table_id' => 'required',
            'restaurant_id' => 'required',
            'booking_date' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0], 'status' => 0], 200);
        } else {
            $getTabelbookDuration =  $this->booktableRepository->getTabledurationList($request->book_table_id);
            $currentTime = date('H:i:s');
            $tableBookarray = array();
            if (count($getTabelbookDuration) > 0) {
                foreach ($getTabelbookDuration as $bkey) {
                    $bkey->disabletime = 0;
                    $checkBookedtableNot = $this->userbooktableRepository->checkBookedtableornot($request->book_table_id, $request->restaurant_id, $request->booking_date, $currentTime, $bkey->id);
                    if (count($checkBookedtableNot) > 0) {
                        $bkey->disabletime = 1;
                    }
                    if ($currentTime >= $bkey->time_from && $currentTime <= $bkey->time_to) {
                    } else {
                        $tableBookarray[] = $bkey;
                    }
                }
                return response()->json(['error_msg' => 'Restaurant table duration data.', 'status' => 1, 'data' => $tableBookarray], $this->successStatus);
            }
            return response()->json(['error_msg' => 'No data found.', 'data' => array(), 'status' => 0], $this->successStatus);
        }
    }
    /*  Book table api */
    public function user_book_table(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'book_table_id' => 'required',
            'number_of_people' => 'required',
            'restaurant_id' => 'required',
            'book_table_time_id' => 'required',
            'booking_date' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0], 'status' => 0], 200);
        } else {
            $currentTime = date('H:i:s');
            $checkBookedtableNot = $this->userbooktableRepository->checkBookedtableornotadd($request->book_table_id, $request->restaurant_id, $request->booking_date, $request->book_table_time_id);

            if (count($checkBookedtableNot) > 0) {
                return response()->json(['error_msg' => 'Already exist booking.', 'data' => array(), 'status' => 0], $this->successStatus);
            }

            $insert = $this->userbooktableRepository->storeBooktable($request);
            if ($insert) {
                $getRestaurantDetail = $this->loginRepository->getRestaurantDetailbyRestaurant($request->restaurant_id);
                $succesNotes = 'For ' . date('d/m/Y', strtotime($request->booking_date)) . ' at ' . $getRestaurantDetail[0]->restaurant_name . ' Booking: ' . $insert->booking_ref_id;
                return response()->json(['error_msg' => 'Table is booked.', 'status' => 1, 'data' => array(array('id' => $insert->id, 'successnote' => $succesNotes))], $this->successStatus);
            } else {
                return response()->json(['error_msg' => 'Something went wrong.', 'data' => array(), 'status' => 0], $this->successStatus);
            }
        }
    }
    /*  Book Food menu category */
    public function food_category_menu(Request $request)
    {
        $user = auth()->user();
        $getFoodmenucategory = $this->foodmenucategoryRepository->getFoodMenuCategoryData();
        $categoryDataarray = array();
        if (count($getFoodmenucategory) > 0) {
            foreach ($getFoodmenucategory as $fkey) {
                $subcategoryDataarray = array();
                $getSUbcategoryDatas = $this->foodmenucategoryRepository->getFoodMenusubCategoryData($fkey->id);
                if (count($getSUbcategoryDatas) > 0) {
                    foreach ($getSUbcategoryDatas as $skey) {
                        $subcategoryDataarray[] = $skey;
                    }
                }
                $fkey->subcategoryData = $subcategoryDataarray;
                $categoryDataarray[$fkey->name] = $fkey;
            }
        }
        return response()->json(['error_msg' => 'Food category.', 'status' => 1, 'data' => $categoryDataarray], $this->successStatus);
    }
    /*  Restaurant Detail */
    public function restaurant_detail(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'restaurant_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0], 'status' => 0], 200);
        } else {
            $getRestaurantDetail = $this->loginRepository->getRestaurantDetailbyRestaurant($request->restaurant_id);
            $restaurantArray = array();
            if (count($getRestaurantDetail) > 0) {
                foreach ($getRestaurantDetail as $rkey) {
                    $cusineData = $this->cuisineRepository->getCuisindataByID($rkey->cuisine_id);
                    $rkey->delivery_charge = '3.50';
                    $rkey->cuisine_name = '';
                    if ($cusineData) {
                        $rkey->cuisine_name = $cusineData->cuisine_name;
                    }
                    // ----- weekly time
                    $getWeeklyTime = $this->loginRepository->getWeekSchedule($rkey->id);
                    if (count($getWeeklyTime) > 0) {
                        $rkey->weekScheduleData = $getWeeklyTime;
                    }
                    // end
                    $getRecentOrder = $this->usercartRepository->getUserrecentTwoorder($rkey->id);
                    $recentOrderArray = array();
                    if (count($getRecentOrder) > 0) {
                        foreach ($getRecentOrder as $okey) {
                            $getMenunameOrder = $this->usercartRepository->getOrderMenunames($okey->id);
                            $okey->menuItem = $getMenunameOrder;
                            $recentOrderArray[] = $okey;
                        }
                    }
                    $rkey->recentOrderdata = $recentOrderArray;
                    $cartData = array();
                    $userCartData = $this->usercartRepository->checkCartsamerestaurantdata($rkey->id);
                    if (count($userCartData) > 0) {
                        $cartData = array(array('totalQty' => $userCartData[0]->qtysum, 'totalPrice' => number_format($userCartData[0]->pricesum, 2)));
                    }
                    $rkey->viewCartdata = $cartData;

                    $getMenucategoryData = $this->menuCategoryRepository->getAllMenuCategory();
                    $menuCategoryMenuwise = array();
                    if (count($getMenucategoryData) > 0) {
                        foreach ($getMenucategoryData as $skey) {
                            $getMenuData = $this->menuRepository->getAllmenuMenuCategorywise($request['restaurant_id'], $skey->id);
                            $menuArraydata = array();
                            $extraMenuArraydata = array();
                            $removeIngredientsArraydata = array();
                            if (count($getMenuData) > 0) {
                                foreach ($getMenuData as $mkey) {
                                    $getAttributeData = $this->menuRepository->getAllmenuAttribute($mkey->restaurant_id, $mkey->id);
                                    $MenuAttributeArray = array();
                                    if (count($getAttributeData) > 0) {
                                        foreach ($getAttributeData as $makey) {
                                            $MenuAttributeArray[] = $makey;
                                        }
                                    }
                                    $mkey->menuAttribute = $MenuAttributeArray;
                                    $menuArraydata[] = $mkey;

                                    // Extra Imtem add
                                    $getExtraItemData = $this->menuRepository->getAllExtraItems($mkey->restaurant_id, $mkey->id);
                                    $ExtraItemArray = array();
                                    if (count($getExtraItemData) > 0) {
                                        foreach ($getExtraItemData as $makeys) {
                                            $ExtraItemArray[] = $makeys;
                                        }
                                    }
                                    $mkey->extraItem = $ExtraItemArray;
                                    $extraMenuArraydata[] = $mkey;
                                    // end Extra items

                                    // Remove Ingredients add
                                    $getRemoveIngredients = $this->menuRepository->getAllRemoveIngredients($mkey->restaurant_id, $mkey->id);
                                    $RemoveIngredientsArray = array();
                                    if (count($getRemoveIngredients) > 0) {
                                        foreach ($getRemoveIngredients as $makeys) {
                                            $RemoveIngredientsArray[] = $makeys;
                                        }
                                    }
                                    $mkey->removeIngredients = $RemoveIngredientsArray;
                                    $removeIngredientsArraydata[] = $mkey;
                                    // end Remove Ingredients
                                }
                                $skey->data = $removeIngredientsArraydata;
                                $menuCategoryMenuwise[] = $skey;
                            }
                        }
                        $rkey->menu_list = $menuCategoryMenuwise;
                    }


                    // $getSubcategoryData = $this->foodmenucategoryRepository->getFoodMenusubCategoryDataAll();
                    // $subcategoryMenuwise = array();
                    // if(count($getSubcategoryData) > 0){
                    //     foreach($getSubcategoryData as $skey){
                    //         $getMenuData = $this->menuRepository->getAllmenuSubcategorywise($request->restaurant_id,$skey->id);
                    //         $menuArraydata = array();
                    //         if(count($getMenuData) > 0){
                    //             foreach($getMenuData as $mkey){

                    //                 $getAttributeData = $this->menuRepository->getAllmenuAttribute($mkey->restaurant_id, $mkey->id);
                    //                 $MenuAttributeArray = array();
                    //                 if(count($getAttributeData) > 0){
                    //                     foreach($getAttributeData as $makey){
                    //                         $MenuAttributeArray[] = $makey;
                    //                     }
                    //                 }
                    //                 $mkey->menuAttribute = $MenuAttributeArray;
                    //                 $menuArraydata[] = $mkey;
                    //             }

                    //             $skey->data = $menuArraydata;
                    //             $subcategoryMenuwise[] = $skey;
                    //         }
                    //     }
                    //     $rkey->menu_list = $subcategoryMenuwise;
                    // }


                    $restaurantArray[] = $rkey;
                }
                return response()->json(['error_msg' => 'Restaurant detail.', 'status' => 1, 'data' => $restaurantArray], $this->successStatus);
            }
            return response()->json(['error_msg' => 'No data found.', 'data' => array(), 'status' => 0], $this->successStatus);
        }
    }

    /*  Add to cart Api */

    public function menu_detail(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'menu_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0], 'status' => 0], 200);
        } else {
            $menuDatadetail =  $this->menuRepository->getMenubyIdwise($request->menu_id);
            if ($menuDatadetail) {
                return response()->json(['error_msg' => 'Menu detail.', 'status' => 1, 'data' => array($menuDatadetail)], $this->successStatus);
            } else {
                return response()->json(['error_msg' => 'No data found.', 'data' => array(), 'status' => 0], $this->successStatus);
            }
        }
    }

    /*  Add to cart Api */
    public function add_to_cart(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'menu_id' => 'required',
            'restaurant_id' => 'required',
            'total_qty' => 'required',
            'total_price' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0], 'status' => 0], 200);
        } else {

            // check same restaurant order or not
            $checkCartSamerestaurant = $this->usercartRepository->checkCartsamerestaurant($request);
            if ($checkCartSamerestaurant) {
                if ($checkCartSamerestaurant->restaurant_id != $request->restaurant_id) {
                    return response()->json(['error_msg' => 'You can ordering the food at a time only one restaurant.', 'data' => array(), 'status' => 0], $this->successStatus);
                    die();
                }
            }

            $setPaymentornot = Owner::find($request->restaurant_id);
            if ($setPaymentornot->stripeflag == '0') {
                return response()->json(['error_msg' => 'Restaurant is offline.', 'data' => array(), 'status' => 0], $this->successStatus);
                die();
            }

            $checkCartdataAdd = $this->usercartRepository->checkCartData($request);
            if ($checkCartdataAdd) {
                $totalQty = $checkCartdataAdd->item_qty + $request->total_qty;
                $totalPrice = $checkCartdataAdd->item_price + $request->total_price;
                if ($request->remove_ingredients != '') {
                    $remove_ingredients = explode(',', $checkCartdataAdd->remove_ingredients);
                    $remove_ingredients1 = explode(',', $request->remove_ingredients);
                    $newData = array_merge($remove_ingredients, $remove_ingredients1);
                    $remove_ingredientsData = implode(',', $newData);
                } else {
                    $remove_ingredientsData = $checkCartdataAdd->remove_ingredients;
                }

                $insert = $this->usercartRepository->updateCartdata($totalQty, $totalPrice, $checkCartdataAdd->id, $remove_ingredientsData);
            } else {
                $insert = $this->usercartRepository->addCartdata($request);
            }
            if ($insert) {
                return response()->json(['error_msg' => 'Add to cart successfully.', 'status' => 1, 'data' => array()], $this->successStatus);
            } else {
                return response()->json(['error_msg' => 'Something went wrong.', 'data' => array(), 'status' => 0], $this->successStatus);
            }
        }
    }
    /* Add to cart with json api */
    public function user_addcart(Request $request)
    {
        $user = auth()->user();
        $cartJson = json_decode($request->cartJson, true);
        if (!empty($cartJson)) {
            $resArray = array();
            foreach ($cartJson as $ckey) {
                $resArray[] = $ckey['restaurant_id'];
            }
            // check same restaurant order or not
            $checkCartSamerestaurant = $this->usercartRepository->checkCartsamerestaurant($request);
            if ($checkCartSamerestaurant) {
                if (in_array($checkCartSamerestaurant->restaurant_id, $resArray)) {
                    foreach ($cartJson as $ckey) {
                        $checkCartdataAdd = $this->usercartRepository->checkCartDataagain($ckey['restaurant_id'], $ckey['menu_id']);
                        if ($checkCartdataAdd) {
                            $totalQty = $checkCartdataAdd->item_qty + $ckey['total_qty'];
                            $totalPrice = $checkCartdataAdd->item_price + $ckey['total_price'];
                            $remove_ingredientsData = '';
                            $insert = $this->usercartRepository->updateCartdata($totalQty, $totalPrice, $checkCartdataAdd->id, $remove_ingredientsData);
                        } else {
                            $insert = $this->usercartRepository->addCartdataWithJosn($ckey['restaurant_id'], $ckey['menu_id'], $ckey['total_qty'], $ckey['total_price']);
                        }
                    }
                    if ($insert) {
                        return response()->json(['error_msg' => 'Add to cart successfully.', 'status' => 1, 'data' => array()], $this->successStatus);
                    } else {
                        return response()->json(['error_msg' => 'Something went wrong.', 'data' => array(), 'status' => 0], $this->successStatus);
                    }
                } else {
                    return response()->json(['error_msg' => 'You can ordering the food at a time only one restaurant.', 'data' => array(), 'status' => 0], $this->successStatus);
                    die();
                }
            } else {
                foreach ($cartJson as $ckey) {
                    $insert = $this->usercartRepository->addCartdataWithJosn($ckey['restaurant_id'], $ckey['menu_id'], $ckey['total_qty'], $ckey['total_price']);
                }

                if ($insert) {
                    return response()->json(['error_msg' => 'Add to cart successfully.', 'status' => 1, 'data' => array()], $this->successStatus);
                } else {
                    return response()->json(['error_msg' => 'Something went wrong.', 'data' => array(), 'status' => 0], $this->successStatus);
                }
            }
        } else {
            return response()->json(['error_msg' => 'Cart data is empty.', 'data' => array(), 'status' => 0], $this->successStatus);
        }
    }
    /*  View cart api */
    public function view_cart(Request $request)
    {
        $user = auth()->user();
        $userCartdata = $this->usercartRepository->getUsercurrentCartdata($user['id']);
        if (count($userCartdata) > 0) {
            return response()->json(['error_msg' => 'View cart.', 'status' => 1, 'data' => $userCartdata], $this->successStatus);
        } else {
            return response()->json(['error_msg' => 'Your cart is empty.', 'data' => array(), 'status' => 0], $this->successStatus);
        }
    }
    /* Add Delievery Address api */
    public function add_delievery_address(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'address_line' => 'required',
            'address_street' => 'required',
            'address_city' => 'required',
            'address_postcode' => 'required',
            'address_country_code' => 'required',
            'address_contact_no' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0], 'status' => 0], 200);
        } else {
            $insert = $this->userRepository->storeUserdelievery_address($request);
            if ($insert) {
                $checkStoreAddress = Userdeliveryaddress::where('user_id', $user['id'])->whereNull('deleted_at')->first();
                return response()->json(['error_msg' => 'Delievery address added successfully.', 'status' => 1, 'data' => array($checkStoreAddress)], $this->successStatus);
            } else {
                return response()->json(['error_msg' => 'Something went wrong.', 'data' => array(), 'status' => 0], $this->successStatus);
            }
        }
    }
    /* Update defualt flag card */
    public function update_card_default_flag(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'card_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0], 'status' => 0], 200);
        } else {
            $updateremovedefualt = Usercarddetail::where('user_id', $user['id'])->update(array('defualt_flag' => '0', 'updated_at' => date('Y-m-d H:i:s'), 'updated_by' => $user['id']));
            $udpateArray = array(
                'defualt_flag' => '1',
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => $user['id']
            );
            $update = Usercarddetail::where('id', $request->card_id)->update($udpateArray);
            if ($update) {
                return response()->json(['error_msg' => 'Default flag updated successfully.', 'status' => 1, 'data' => array()], $this->successStatus);
            } else {
                return response()->json(['error_msg' => 'Something went wrong.', 'data' => array(), 'status' => 0], $this->successStatus);
            }
        }
    }
    /* Add Payment method */
    public function add_payment_details(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'name_of_card' => 'required',
            'card_number' => 'required',
            'exp_month' => 'required',
            'exp_year' => 'required',
            'cvc' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0], 'status' => 0], 200);
        } else {


            try {
                Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
                $token = $stripe->tokens->create([
                    'card' => [
                        'number' => $request->card_number,
                        'exp_month' => $request->exp_month,
                        'exp_year' => $request->exp_year,
                        'cvc' => $request->cvc,
                    ],
                ]);

                if (!empty($token)) {
                    $customer = \Stripe\Customer::create(array(
                        'name' => $request->name_of_card,
                        'email' => $user['email'],
                        'source' => $token->id
                    ));

                    if (!empty($customer)) {

                        $insert = $this->userRepository->storeUsercardDetail($request->name_of_card, $customer->id, $customer);
                        return response()->json(['error_msg' => 'Card added successfully.', 'status' => 1, 'data' => array()], $this->successStatus);
                    } else {
                        return response()->json(['error_msg' => 'Something went wrong.', 'data' => array(), 'status' => 0], $this->successStatus);
                    }
                } else {
                    return response()->json(['error_msg' => 'Something went wrong.', 'data' => array(), 'status' => 0], $this->successStatus);
                }
            } catch (Exception $e) {
                return response()->json(['error_msg' => 'Something went wrong.', 'data' => array(), 'status' => 0], $this->successStatus);
            }
        }
    }
    /*  Card List api */
    public function card_list(Request $request)
    {
        $user = auth()->user();
        $getUserCarddata = $this->userRepository->getUsercardData($user['id']);
        $cardDetail = array();
        if (count($getUserCarddata) > 0) {
            foreach ($getUserCarddata as $ckey) {
                $cust_id = $ckey->stripe_customer_id;
                $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
                $customer = $stripe->customers->retrieve(
                    $cust_id,
                    []
                );

                $customer_detail = $stripe->customers->retrieveSource(
                    $customer->id,
                    $customer->default_source
                );
                $ckey->last4 = $customer_detail['last4'];
                $ckey->brand = $customer_detail['brand'];
                $cardDetail[] = $ckey;
            }
        }

        if (!empty($cardDetail)) {
            return response()->json(['error_msg' => 'Card list.', 'status' => 1, 'data' => $cardDetail], $this->successStatus);
        } else {
            return response()->json(['error_msg' => 'No data found.', 'data' => array(), 'status' => 0], $this->successStatus);
        }
    }
    /*  Card detail and delivery address */
    public function user_delivery_address_payment_list(Request $request)
    {
        $user = auth()->user();
        $user_delivery_address = $this->userRepository->getUserdeliveryAddress($user['id']);
        $user_payment_list =  $this->userRepository->getUserpaymentData($user['id']);
        if ($user_payment_list) {
            $cust_id = $user_payment_list->stripe_customer_id;
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $customer = $stripe->customers->retrieve(
                $cust_id,
                []
            );

            $customer_detail = $stripe->customers->retrieveSource(
                $customer->id,
                $customer->default_source
            );
            $cardDetail[] = $customer_detail;
            $user_payment_list->card_number = 'Card ending in ** **** ' . $cardDetail[0]['last4'];
            $user_payment_list->exp_month_year = $cardDetail[0]['exp_month'] . '/' . $cardDetail[0]['exp_year'];
        }

        $useraddress_payment = array('user_delivery_address' => $user_delivery_address, 'user_payment_list' => $user_payment_list);
        return response()->json(['error_msg' => 'User delivery data and payment list.', 'status' => 1, 'data' => array($useraddress_payment)], $this->successStatus);
    }
    /*  User Order Book Table api */
    public function user_order_book_table(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'number_of_people' => 'required',
            'restaurant_id' => 'required',
            'booking_date' => 'required',
            'booking_time' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0], 'status' => 0], 200);
        } else {
            $currentTime = date('H:i:s');
            // $checkBookedtableNot = $this->userbooktableRepository->checkBookedtableornotadd($request->book_table_id, $request->restaurant_id, $request->booking_date, $request->book_table_time_id);


            // if (count($checkBookedtableNot) > 0) {
            //     return response()->json(['error_msg' => 'Already exist booking.', 'data' => array(), 'status' => 0], $this->successStatus);
            // }

            $insert = $this->userbooktableRepository->storeBooktable($request);
            if ($insert) {  
                //$gettableTime = $this->loginRepository->getBooktableTime($request->book_table_time_id);
                $getRestaurantDetail = $this->loginRepository->getRestaurantDetailbyRestaurant($request->restaurant_id);
                $resname = $getRestaurantDetail[0]->restaurant_name;
                $datetime = date("l, d M Y", strtotime($request->booking_date));
                $time = date("h:i:s",strtotime($request->booking_time));
                $guest = $request->number_of_people;

               // send notification to user book table
               $did = $user['id'];
                $title = 'Booking confirmation';
                $msg = 'Reservation at ' . $resname . ' ' . $datetime . ' for ' . $guest . ' guests at ' . $time . '';
                $notifications = self::sendNotification($did, $title, $msg, '2', $request->book_table_id);


               $succesNotes = 'For ' . $request->number_of_people . ', ' . date('d,M', strtotime($request->booking_date)) . ' at ' . date('h:i', strtotime($request->booking_time));
                return response()->json(['error_msg' => 'Table is booked.', 'status' => 1, 'data' => array(array('id' => $insert->id, 'successnote' => $succesNotes))], $this->successStatus);
            } else {
                return response()->json(['error_msg' => 'Something went wrong.', 'data' => array(), 'status' => 0], $this->successStatus);
            }
        }
    }
    /*  Book order api */
    public function book_order(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'restaurant_id' => 'required',
            'order_type' => 'required',
            'estimated_min' => 'required',
            //'delivery_id' => 'required',
            'discount'      =>  'required',
            'payment_id' => 'required',
            // 'delivery_charge' => 'required',
            'sub_total' => 'required',
            'total_amount' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0], 'status' => 0], 200);
        } else {
            if ($request->order_type == '2') {
                if ($request->book_table_id == '') {
                    return response()->json(['error_msg' => 'Please add book table.', 'data' => array(), 'status' => 0], $this->successStatus);
                    die();
                }
            }

            $totalOrders = Owner::find($request->restaurant_id);
            if ($totalOrders) {
                if ($totalOrders->total_orders <= 0) {
                    return response()->json(['error_msg' => 'Restaurant is deactivated.', 'data' => array(), 'status' => 0], $this->successStatus);
                    die();
                }
            }

            $orderItemjson = json_decode($request->orderItemjson, true);
            $insert = $this->ordermasterRepository->storeOrder($request, $orderItemjson);
            if ($insert == '0') {
                return response()->json(['error_msg' => 'Something went wrong.', 'data' => array(), 'status' => 0], $this->successStatus);
            } else {
                if ($insert) {
                    $getOrderId = Ordermaster::where('user_id',$user->id)->orderBy('id','desc')->first();
                    $getRestroName = Owner::select('restaurant_name')->where('id',$getOrderId->restaurant_id)->first();
                    $userTitle = 'Order Confirmed';
                    $userMessage = $getRestroName->restaurant_name.' '."has confirmed your".' '.$getOrderId->order_number;

                    self::userSendNotification($user->id,$userTitle,$userMessage,'6');

                    $totalCartorder = $totalOrders->total_orders - 1;

                    $update = Owner::where('id', $request->restaurant_id)->update(array('total_orders' => $totalCartorder, 'updated_at' => date('Y-m-d H:i:s')));

                    return response()->json(['error_msg' => 'Your order booked successfully.', 'status' => 1, 'data' => array(array('order_number' => $insert->order_number))], $this->successStatus);
                } else {
                    return response()->json(['error_msg' => 'Something went wrong.', 'data' => array(), 'status' => 0], $this->successStatus);
                }
            }
        }
    }
    /*  User current order api */
    public function user_current_order(Request $request)
    {
        $user = auth()->user();
        $getUsercurrentOrder = $this->ordermasterRepository->getUsercurrentOrders($user['id']);
        $orderArray = array();
        if (count($getUsercurrentOrder) > 0) {
            foreach ($getUsercurrentOrder as $okey) {
                $getRestaurantDetail = $this->loginRepository->getRestaurantDetailbyRestaurant($okey->restaurant_id);
                $okey->restaurant_name = '';
                if (count($getRestaurantDetail) > 0) {
                    $okey->restaurant_name = $getRestaurantDetail[0]->restaurant_name;
                }
                $time = date('H:i:s', strtotime($okey->order_date_time));
                $estimatedHour = date('H:i:s', strtotime($time . ' +' . $okey->estimated_min . ' minutes'));
                $okey->estimated_arrival = date('h:i A', strtotime($okey->order_date_time)) . ' - ' . date("h:i A", strtotime($estimatedHour));
                $orderArray[] = $okey;
            }
        }
        if (!empty($orderArray)) {
            return response()->json(['error_msg' => 'Your current order.', 'status' => 1, 'data' => $orderArray], $this->successStatus);
        } else {
            return response()->json(['error_msg' => 'No current order.', 'data' => array(), 'status' => 0], $this->successStatus);
        }
    }
    /*  User current order api */
    public function user_current_order_detail(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'order_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0], 'status' => 0], 200);
        } else {
            $getUsercurrentOrder = $this->ordermasterRepository->getUsercurrentOrdersbyID($user['id'], $request->order_id);
            if ($getUsercurrentOrder) {
                $getRestaurantDetail = $this->loginRepository->getRestaurantDetailbyRestaurant($getUsercurrentOrder->restaurant_id);
                $getUsercurrentOrder->restaurant_name = '';
                if (count($getRestaurantDetail) > 0) {
                    $getUsercurrentOrder->restaurant_name = $getRestaurantDetail[0]->restaurant_name;
                }
                $time = date('H:i:s', strtotime($getUsercurrentOrder->order_date_time));
                $estimatedHour = date('H:i:s', strtotime($time . ' +' . $getUsercurrentOrder->estimated_min . ' minutes'));
                $getUsercurrentOrder->estimated_arrival = date('h:i A', strtotime($getUsercurrentOrder->order_date_time)) . ' - ' . date("h:i A", strtotime($estimatedHour));
                $userDAdress = $this->userRepository->getUserdeliveryAddress($user['id']);
                $user_delivery_address = '';
                if ($userDAdress) {
                    $user_delivery_address = $userDAdress->address_line . ' ' . $userDAdress->address_street . ' ' . $userDAdress->address_city . ' ' . $userDAdress->address_postcode;
                }
                $getUsercurrentOrder->user_delivery_address = $user_delivery_address;
                $getUsercurrentOrder->order_status_history = $this->ordermasterRepository->orderStatushistory($user['id'], $request->order_id);

                $getUsercurrentOrder->order_item = $this->ordermasterRepository->orderItemByorderID($user['id'], $request->order_id);

                $getUsercurrentOrder->order_data
                    = $this->ordermasterRepository->orderDataByorderID($user['id'], $request->order_id);
            }
            return response()->json(['error_msg' => 'Your current order detail.', 'status' => 1, 'data' => array($getUsercurrentOrder)], $this->successStatus);
        }
    }
    /*  My bookings api */
    public function my_bookings(Request $request)
    {
        $user = auth()->user();
        $currentDate = date('Y-m-d');
        $currentTime = date('H:i:s');

        $getBooktableUser = $this->userbooktableRepository->getBooktableWithdateandtime($currentDate, $currentTime, $user['id']);
        $newArray = array();
        if (count($getBooktableUser) > 0) {
            foreach ($getBooktableUser as $ckey) {
                $getTimetable = $this->userbooktableRepository->getRecordbyTime($ckey->book_table_time_id);
                if(isset($getTimetable))
                {
                    $ckey->time_from = $getTimetable->time_from;
                    $getRestaurantDetail = $this->loginRepository->getRestaurantDetailbyRestaurant($ckey->restaurant_id);
                    $ckey->restaurant_name = '';
                    if (count($getRestaurantDetail) > 0) {
                        $ckey->restaurant_name = $getRestaurantDetail[0]->restaurant_name;
                    }
                    $ckey->datenotes = date('d M', strtotime($ckey->book_date)) . ' at ' . $getTimetable->time_from;
                }
               
                $newArray[] = $ckey;
                
            }
        }

        if (!empty($newArray)) {
            return response()->json(['error_msg' => 'My bookings.', 'data' => $newArray, 'status' => 1], $this->successStatus);
        } else {
            return response()->json(['error_msg' => 'No data found.', 'data' => array(), 'status' => 0], $this->successStatus);
        }
    }
    /*  Cancel Booking api */
    public function cancel_booking(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0], 'status' => 0], 200);
        } else {
            $currentDate = date('Y-m-d');
            $currentTime = date('H:i:s');
            $getTimetable = $this->userbooktableRepository->getBookTableWithDateAndTimeAPI($currentDate, $currentTime, $user->id);
            if (count($getTimetable) > 0) {
                $deleteBooking = Userbooktable::where('id', $request->id)->update(['table_status' => 0]);
                return response()->json(['error_msg' => 'Cancel booking successfully.', 'data' => array(), 'status' => 1], $this->successStatus);
            } else {
                return response()->json(['error_msg' => 'No data found.', 'data' => array(), 'status' => 0], $this->successStatus);
            }
        }
    }
    /*  Edit Booking api */
    public function edit_booking(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0], 'status' => 0], 200);
        } else {
            $currentTime = date('H:i:s');
            $getUsertablebookingData = $this->userbooktableRepository->getUserbooktableDataById($request->id);
            if ($getUsertablebookingData) {
                $getRestaurantDetail = $this->loginRepository->getRestaurantDetailbyRestaurant($getUsertablebookingData->restaurant_id);
                $getUsertablebookingData->restaurant_name = '';
                if (count($getRestaurantDetail) > 0) {
                    $getUsertablebookingData->restaurant_name = $getRestaurantDetail[0]->restaurant_name;
                }
                $getTabelbookDuration =  $this->booktableRepository->getTabledurationList($getUsertablebookingData->book_table_id);
                $currentTime = date('H:i:s');
                $tableBookarray = array();
                if (count($getTabelbookDuration) > 0) {
                    foreach ($getTabelbookDuration as $bkey) {
                        $bkey->disabletime = 0;
                        $bkey->selectedtime = 0;
                        $checkBookedtableNot = $this->userbooktableRepository->checkBookedtableornot($getUsertablebookingData->book_table_id, $getUsertablebookingData->restaurant_id, $getUsertablebookingData->book_date, $currentTime, $bkey->id);
                        if (count($checkBookedtableNot) > 0) {
                            $bkey->disabletime = 1;
                        }
                        if ($bkey->id == $getUsertablebookingData->book_table_time_id) {
                            $bkey->selectedtime = 1;
                            $bkey->disabletime = 0;
                        }
                        if ($currentTime >= $bkey->time_from && $currentTime <= $bkey->time_to) {
                        } else {
                            $tableBookarray[] = $bkey;
                        }
                    }
                }
                $getUsertablebookingData->time_data = $tableBookarray;
                return response()->json(['error_msg' => 'Edit booking.', 'data' => array($getUsertablebookingData), 'status' => 1], $this->successStatus);
            } else {
                return response()->json(['error_msg' => 'No data found.', 'data' => array(), 'status' => 0], $this->successStatus);
            }
        }
    }
    /*  Update booking api */
    public function update_booking(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'number_of_people' => 'required',
            'restaurant_id' => 'required',
            'booking_date' => 'required',
            'booking_time' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0], 'status' => 0], 200);
        } else {

            $checkOrdersStatus = $this->ordermasterRepository->CheckOrderstatus($request->id, $user['id']);
            if (count($checkOrdersStatus) > 0) {
                return response()->json(['error_msg' => 'Your order is cancelled.', 'data' => array(), 'status' => 0], $this->successStatus);
                die();
            }
            $updateBooking = $this->userbooktableRepository->updatetableBooking($request);
            if ($updateBooking) {
                return response()->json(['error_msg' => 'Booking updated successfully.', 'data' => array(), 'status' => 1], $this->successStatus);
            } else {
                return response()->json(['error_msg' => 'Something went wrong.', 'data' => array(), 'status' => 0], $this->successStatus);
            }
        }
    }
    /*  My profile api */
    public function my_profile(Request $request)
    {
        $user = auth()->user();
        if (!empty($user)) {
            return response()->json(['error_msg' => 'My profile.', 'data' => array($user), 'status' => 1], $this->successStatus);
        } else {
            return response()->json(['error_msg' => 'Something went wrong.', 'data' => array(), 'status' => 0], $this->successStatus);
        }
    }
    /*  Update My Profile api */
    public function update_my_profile(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'country_code' => 'required',
            'mobile_no' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0], 'status' => 0], 200);
        } else {
            $updateProfile = $this->userRepository->updateProfile($request);
            if ($updateProfile) {
                $user = User::find($user['id']);
                return response()->json(['error_msg' => 'Profile updated successfully.', 'data' => array($user), 'status' => 1], $this->successStatus);
            } else {
                return response()->json(['error_msg' => 'Something went wrong.', 'data' => array(), 'status' => 0], $this->successStatus);
            }
        }
    }
    /*  Update My Profile api */
    public function update_device_token(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'device_token' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0], 'status' => 0], 200);
        } else {
            $updateProfile = $this->userRepository->updateDevicetoken($request);
            if ($updateProfile) {
                return response()->json(['error_msg' => 'Token updated successfully.', 'data' => array(), 'status' => 1], $this->successStatus);
            } else {
                return response()->json(['error_msg' => 'Something went wrong.', 'data' => array(), 'status' => 0], $this->successStatus);
            }
        }
    }
    /*  notification list api */
    public function notification_list(Request $request)
    {
        $user = auth()->user();
        $getNotificationlist = $this->notificationRepository->getNotificationData($user['id']);
        if (count($getNotificationlist) > 0) {
            return response()->json(['error_msg' => 'Notification list.', 'data' => $getNotificationlist, 'status' => 1], $this->successStatus);
        } else {
            return response()->json(['error_msg' => 'No data found.', 'data' => array(), 'status' => 0], $this->successStatus);
        }
    }
    /*  User seated or not api*/
    public function user_seated(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'user_book_table_id' => 'required',
            'notification_id' => 'required',
            'seated_flag' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0], 'status' => 0], 200);
        } else {
            $update =  $this->userbooktableRepository->updatetableBookingseated($request);
            if ($update) {
                if ($request->seated_flag == '1') {
                    $notificationDelete = Notification::where('id', $request->notification_id)->delete();
                    $recentlyVisitrestaurants = $this->userRepository->recentlyVisitrestaurantsuser($request);
                    return response()->json(['error_msg' => 'User is seated successfully.', 'data' => array(), 'status' => 1], $this->successStatus);
                } else {
                    $notificationDelete = Notification::where('id', $request->notification_id)->delete();
                    return response()->json(['error_msg' => 'Your table is ready. Please seated on table.', 'data' => array(), 'status' => 1], $this->successStatus);
                }
            } else {
                return response()->json(['error_msg' => 'Something went wrong.', 'data' => array(), 'status' => 0], $this->successStatus);
            }
        }
    }
    /*  User seated or not api*/
    public function my_saved_places(Request $request)
    {
        $user = auth()->user();
        $searchvalue = $request->searchvalue;
        if ($searchvalue != '') {
            $savePlaces = $this->userRepository->mysavePlacesbySearch($user['id'], $searchvalue);
        } else {
            $savePlaces = $this->userRepository->mysavePlaces($user['id']);
        }

        if (count($savePlaces) > 0) {
            $restuarantsaveArray = array();
            foreach ($savePlaces as $key) {
                $getRestaurantDetail = $this->loginRepository->getRestaurantDetailbyRestaurant($key->restaurant_id);
                if (count($getRestaurantDetail) > 0) {
                    foreach ($getRestaurantDetail as $rkey) {
                        $cusineData = $this->cuisineRepository->getCuisindataByID($rkey->cuisine_id);
                        $rkey->delivery_charge = '3.50';
                        $rkey->cuisine_name = '';
                        if ($cusineData) {
                            $rkey->cuisine_name = $cusineData->cuisine_name;
                        }
                        $saverestaurant = $this->saverestaurantRepository->checkSavedornot($rkey->id, $user['id']);
                        $rkey->save_restaurant = '0';
                        if ($saverestaurant) {
                            $rkey->save_restaurant = '1';
                        }
                        $restuarantsaveArray[] = $rkey;
                    }
                }
            }
            return response()->json(['error_msg' => 'My save places.', 'data' => $restuarantsaveArray, 'status' => 1], $this->successStatus);
        } else {
            return response()->json(['error_msg' => 'No data found.', 'data' => array(), 'status' => 0], $this->successStatus);
        }
    }
    /*  update my email address api */
    public function update_email_address(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0], 'status' => 0], 200);
        } else {
            $checkEmailexist = $this->userRepository->checkEmailuserNotID($request->email);
            if ($checkEmailexist) {
                return response()->json(['error_msg' => 'Email already exist.', 'data' => array(), 'status' => 0], $this->successStatus);
            } else {
                $updateProfile = $this->userRepository->updateEmailaddress($request);
                if ($updateProfile) {
                    return response()->json(['error_msg' => 'Email address updated successfully.', 'data' => array(), 'status' => 1], $this->successStatus);
                } else {
                    return response()->json(['error_msg' => 'Something went wrong.', 'data' => array(), 'status' => 0], $this->successStatus);
                }
            }
        }
    }
    /*  update my password api */
    public function update_password(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:6|same:confirm_password',
            'confirm_password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0], 'status' => 0], 200);
        } else {
            if (!Hash::check(request('current_password'), $user['password'])) {
                return response()->json(['error_msg' => 'Current password does not match.', 'data' => array(), 'status' => 0], $this->successStatus);
                die();
            } else {
                $updateProfile = $this->userRepository->updateNewpassword($request);
                if ($updateProfile) {
                    return response()->json(['error_msg' => 'Password updated successfully.', 'data' => array(), 'status' => 1], $this->successStatus);
                } else {
                    return response()->json(['error_msg' => 'Something went wrong.', 'data' => array(), 'status' => 0], $this->successStatus);
                }
            }
        }
    }
    /*  Order History API */
    public function order_history(Request $request)
    {
        $user = auth()->user();
        $getUserOrderhistory = $this->ordermasterRepository->getUserOrdershistory($user['id']);
        $orderArray = array();
        if (count($getUserOrderhistory) > 0) {
            foreach ($getUserOrderhistory as $okey) {
                $getRestaurantDetail = $this->loginRepository->getRestaurantDetailbyRestaurant($okey->restaurant_id);
                $getMenunameOrder = $this->usercartRepository->getOrderMenunames($okey->id);
                $okey->restaurant_name = '';
                if (count($getRestaurantDetail) > 0) {
                    $okey->restaurant_name = $getRestaurantDetail[0]->restaurant_name;
                }

                $okey->menuItem = $getMenunameOrder;
                $orderArray[] =  $okey;
            }
        }
        if (!empty($orderArray)) {
            return response()->json(['error_msg' => 'Your order history.', 'status' => 1, 'data' => $orderArray], $this->successStatus);
        } else {
            return response()->json(['error_msg' => 'No order.', 'data' => array(), 'status' => 0], $this->successStatus);
        }
    }
    /*  Order detail api */
    public function order_detail(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'order_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0], 'status' => 0], 200);
        } else {
            $getUserOrderhistory = $this->ordermasterRepository->getUserOrdershistorybyOrderID($user['id'], $request->order_id);
            if ($getUserOrderhistory) {
                $getRestaurantDetail = $this->loginRepository->getRestaurantDetailbyRestaurant($getUserOrderhistory->restaurant_id);
                $getUserOrderhistory->restaurant_name = '';
                if (count($getRestaurantDetail) > 0) {
                    $getUserOrderhistory->restaurant_name = $getRestaurantDetail[0]->restaurant_name;
                }
                $userDAdress = $this->userRepository->getUserdeliveryAddress($user['id']);
                $user_delivery_address = '';
                if ($userDAdress) {
                    $user_delivery_address = $userDAdress->address_line . ' ' . $userDAdress->address_street . ' ' . $userDAdress->address_city . ' ' . $userDAdress->address_postcode;
                }
                $getUserOrderhistory->user_delivery_address = $user_delivery_address;
                $getUserOrderhistory->order_item = $this->ordermasterRepository->orderItemByorderID($user['id'], $request->order_id);
                $getUserOrderhistory->order_data
                    = $this->ordermasterRepository->orderDataByorderID($user['id'], $request->order_id);
            }
            return response()->json(['error_msg' => 'Your order detail.', 'status' => 1, 'data' => array($getUserOrderhistory)], $this->successStatus);
        }
    }
    /* FAQ data */
    public function faq_data(Request $request)
    {
        $getFAQdata = $this->userRepository->getFAQdata();
        if (count($getFAQdata) > 0) {
            return response()->json(['error_msg' => 'FAQ data.', 'data' => $getFAQdata, 'status' => 1], $this->successStatus);
        } else {
            return response()->json(['error_msg' => 'No data found.', 'data' => array(), 'status' => 0], $this->successStatus);
        }
    }
    /* CMS data */
    public function cms_data(Request $request)
    {
        $getCMSdata = $this->userRepository->getCMSdata();
        if (count($getCMSdata) > 0) {
            return response()->json(['error_msg' => 'CMS data.', 'data' => $getCMSdata, 'status' => 1], $this->successStatus);
        } else {
            return response()->json(['error_msg' => 'No data found.', 'data' => array(), 'status' => 0], $this->successStatus);
        }
    }
    /* CMS data */
    public function help_support(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'full_name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0], 'status' => 0], 200);
        } else {
            $insert = $this->userRepository->addHelpsupportData($request);
            if ($insert) {
                return response()->json(['error_msg' => 'Thank You! We will contact you shortly.', 'data' => array(), 'status' => 1], $this->successStatus);
            } else {
                return response()->json(['error_msg' => 'Something went wrong.', 'data' => array(), 'status' => 0], $this->successStatus);
            }
        }
    }
    /* Promo code check */
    public function check_promocode(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'promo_code' => 'required',
            'resturent_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0], 'status' => 0], 200);
        } else {

            $checkPromocode = $this->discountRepository->checkPromocode($request->promo_code, $request->resturent_id);
            if ($checkPromocode) {
                return response()->json(['error_msg' => 'Valid promocode.', 'data' => array($checkPromocode), 'status' => 1], $this->successStatus);
            } else {
                return response()->json(['error_msg' => 'Invalid Promocode.', 'data' => array(), 'status' => 0], $this->successStatus);
            }
        }
    }
    /* Remove cart check */
    public function remove_cart(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'cart_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0], 'status' => 0], 200);
        } else {

            $checkCartdata = $this->usercartRepository->checkCartdataDelete($request->cart_id, $user['id']);
            if ($checkCartdata) {
                $deleteCart = Usercart::where('id', $request->cart_id)->delete();
                return response()->json(['error_msg' => 'Cart remove successfully.', 'data' => array(), 'status' => 1], $this->successStatus);
            } else {
                return response()->json(['error_msg' => 'No data found.', 'data' => array(), 'status' => 0], $this->successStatus);
            }
        }
    }
    /* API Notification sent */
    public function sendNotification($userid, $title, $msg, $type = '', $user_book_table_id)
    {

        $getDrivertoken = $this->userRepository->getByIddata($userid);
        date_default_timezone_set('UTC');
        $insarray = array(
            "user_id" => $userid,
            "user_book_table_id" => $user_book_table_id,
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
    /*  Distace in KM two lat long */
    public static function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'miles')
    {
        $theta = $longitude1 - $longitude2;
        $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
        $distance = acos($distance);
        $distance = rad2deg($distance);
        $distance = $distance * 60 * 1.1515;
        switch ($unit) {
            case 'miles':
                break;
            case 'kilometers':
                $distance = $distance * 1.609344;
        }
        return (round($distance, 2));
    }
}
