<?php

namespace App\Repositories\admin;

use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\ImageUploadTrait;
use App\Interfaces\admin\LoginRepositoryInterface;
use App\Models\admin\BookTable;
use App\Models\admin\Owner;
use App\Models\admin\BookTableDuration;
use App\Models\admin\Cuisine;
use App\Models\admin\Menu;
use App\Models\admin\Ordermaster;
use App\Models\admin\User;
use App\Models\admin\WeekTimeSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use DB;
use Hash;

class LoginRepository implements LoginRepositoryInterface
{
    use ImageUploadTrait;
    public function updateAdminpassword(Request $request)
    {
        $password = Hash::make($request->new_password);
        $updateArray = array(
            'password' => $password,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => auth()->guard('restaurantportal')->user()->id
        );
        return Owner::where('id', auth()->guard('restaurantportal')->user()->id)->update($updateArray);
    }

    public function insertOwnerdata(Request $request)
    {
        $restaurant_type = '';
        if ($request->restaurant_type != '') {
            $restaurant_type = implode(',', $request->restaurant_type);
        }
        if ($request->hasFile('restaurant_image')) {
            $image = $this->uploadImage($request->file('restaurant_image'), 'restaurant_image');
        } else {
            $image = '';
        }

        // check cuisine

        /*$checkCuisns = Cuisine::whereRaw('cuisine_name LIKE "%' . $request->cuisine_id . '%"')->whereNull('deleted_at')->first();
        if($checkCuisns){
            $cuisine_id = $checkCuisns->id;
        }else{
            $insertARray = array(
                'cuisine_name' => $request->cuisine_id,
                'created_at' => date('Y-m-d H:i:s')
            );
            $insert = new Cuisine($insertARray);
            $insert->save();
            $cuisine_id = $insert->id;
        }*/

        $password = Hash::make($request->password);
        $insertArray = array(
            'restaurant_name' => $request->restaurant_name,
            'owner_name' => $request->owner_name,
            'business_number' => $request->business_number,
            'email' => $request->email,
            'country_code' => $request->country_code,
            'phone_no' => $request->phone_no,
            'address' => $request->address,
            'addresslinetwo' => $request->addresslinetwo,
            'pincode' => $request->pincode,
            'street' => $request->street,
            'cuisine_id' => $request->cuisine_id,
            'restaurant_type' => $restaurant_type,
            'restaurant_image' => $image,
            'city' => $request->city,
            'restaurant_open_time' => date("H:i:s", strtotime($request->starttime)),
            'restaurant_close_time' => date("H:i:s", strtotime($request->endtime)),
            'restaurant_latitude' => $request->restaurant_latitude,
            'restaurant_longitude' => $request->restaurant_longitude,
            'password' => $password,
            'subscription_flag' => '1',
            'total_orders' => '100',
            'plan_id' => '1',
            'created_at' => date('Y-m-d H:i:s')
        );
        // dd($insertArray);

        return Owner::create($insertArray);
    }
    public function checkForgotEmail($email)
    {
        return Owner::where('email', $email)->whereNull('deleted_at')->first();
    }
    public function checkForgotPhoneno($phone)
    {
        return Owner::where('phone_no', $phone)->whereNull('deleted_at')->first();
    }
    public function checkForgotBusinessnumber($business_number)
    {
        return Owner::where('business_number', $business_number)->whereNull('deleted_at')->first();
    }
    public function getAllorders($id)
    {
        return Ordermaster::where('restaurant_id', $id)->whereNull('deleted_at')->count();
    }
    public function getTables($id)
    {
        return BookTable::where('restaurant_id', $id)->whereNull('deleted_at')->count();
    }
    public function getUserbooktableorder($id)
    {
        return Ordermaster::where('restaurant_id', $id)->where('order_type', '2')->whereNull('deleted_at')->count();
    }

    public function getbyOTP($otpchange)
    {

        return Owner::where('otp', $otpchange)->whereNull('deleted_at')->first();
    }

    public function updateAdmin($email, $data)
    {
        $update = Owner::where('email', $email)->update($data);
        return $update;
    }
    public function getRestaurantDetailbyRestaurant($restaurant_id)
    {
        return Owner::where('id', $restaurant_id)->whereNull('deleted_at')->where('status', '1')->orderBy('id', 'desc')->get();
    }
    public function getBooktableTime($id)
    {
        return BookTableDuration::where('id', $id)->whereNull('deleted_at')->first();
    }
    public function getAllvenue()
    {
        return Owner::select('id', 'restaurant_name', 'restaurant_image')->whereNull('deleted_at')->where('status', '1')->get();
    }
    public function gettotalMonthlyordersRev($id)
    {
        return Ordermaster::whereNull('deleted_at')->where('restaurant_id', $id)->where('order_status', '!=', 'Rejected Order')->sum('total_amount');
    }
    public function getAllvenueseachbyName($name)
    {
        return Owner::select('id', 'restaurant_name', 'restaurant_image')->whereNull('deleted_at')->where('status', '1')->whereRaw('lower(restaurant_name) like (?)', ["%{$name}%"])->get();
    }

    public function getRestaurantDetailnearYou($live_lattitude, $live_longitude, $distance)
    {
        $query = Owner::selectRaw(
            'fs_owner.*, 111.111 *
            DEGREES(ACOS(LEAST(1.0, COS(RADIANS(' . $live_lattitude . '))
            * COS(RADIANS(fs_owner.restaurant_latitude))
            * COS(RADIANS(' . $live_longitude . ' - restaurant_longitude))
            + SIN(RADIANS(' . $live_lattitude . '))
            * SIN(RADIANS(fs_owner.restaurant_latitude))))) AS distance_in_km'
        )
            ->where('fs_owner.status', '1')
            ->whereNull('fs_owner.deleted_at')
            ->where('fs_owner.total_orders', '>', 0)
            ->where('fs_owner.stripeflag', 1)
            ->having('distance_in_km', '<', $distance)
            ->orderBy('fs_owner.id', 'desc')
            ->get();
        return $query;
    }

    public function getResturentByfoodType($live_lattitude, $live_longitude, $categoryId, $distance)
    {
        $cnd = ' fs_owner.status = "1" and fs_owner.deleted_at IS NULL';

        /*if ($food_type != '') {
            $cnd .= ' and fs_menu.food_type_id  = ' . $food_type . '';
        }*/
        if ($categoryId != '') {
            $cnd .= ' and fs_menu.category_id   = ' . $categoryId . '';
        }

        $query = Menu::select('fs_owner.*')
            ->leftJoin('fs_owner', 'fs_menu.restaurant_id', '=', 'fs_owner.id')
            ->whereRaw($cnd)
            ->where('fs_owner.total_orders', '>', 0)
            ->where('fs_owner.stripeflag', 1)
            ->groupBy('fs_menu.restaurant_id')
            ->get();
        return $query;
    }
    public function getRestaurantDetailByfilter($live_lattitude, $live_longitude, $cuisine_id, $price, $distance)
    {
        $cnd = ' fs_owner.status = "1" and fs_owner.deleted_at IS NULL';
        if ($price) {
            $cnd .= ' and FIND_IN_SET(' . $price . ',fs_owner.restaurant_type)';
        }
        if ($cuisine_id != '') {
            if ($cuisine_id != 'all') {
                $cnd .= ' and fs_owner.cuisine_id  = ' . $cuisine_id . '';
            }
        }

        $query = Owner::selectRaw(
            'fs_owner.*, ((ACOS(SIN(' .
                $live_lattitude .
                ' * PI() / 180) * SIN(fs_owner.restaurant_latitude * PI() / 180) + COS(' .
                $live_lattitude .
                ' * PI() / 180) * COS(fs_owner.restaurant_latitude * PI() / 180) * COS((' .
                $live_longitude .
                ' - fs_owner.restaurant_longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515)  AS distance'
        )
            ->whereRaw($cnd)
            ->where('fs_owner.total_orders', '>', 0)
            ->where('fs_owner.stripeflag', 1)
            ->having('distance', '<', $distance)
            ->get();
        return $query;
    }
    public function getAppuerList(Request $request)
    {


        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', array(1, 'asc'));


        $sortcolumns = array(
            0 => 'fs_user.first_name',
            1 => 'fs_user.email',
            2 => 'fs_user.mobile_no',

        );

        $query = User::getAllAppUsers();

        $recordstotal = $query->count();
        $sortColumnName = $sortcolumns[$order[0]['column']];

        $query
            //->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $json = array(
            'draw' => $draw,
            'recordsTotal' => $recordstotal,
            'recordsFiltered' => $recordstotal,
            'data' => [],
        );

        // $foodmenu = $query->latest()->get();
        $foodmenu = $query;
        $no =  $start + 1;
        foreach ($foodmenu as $user) {

            $userName = $user->first_name . ' ' . $user->last_name;


            $json['data'][] = [
                $no,
                $userName,
                $user->email,
                "+" . $user->country_code . ' ' . $user->mobile_no,
                date('d/m/Y h:i A', strtotime($user->created_at)),
            ];

            $no++;
        }
        return $json;
    }

    public function getWeekSchedule($id)
    {
        $query = WeekTimeSetting::select('fs_week_schedule.day', 'fs_week_schedule.open_time', 'fs_week_schedule.close_time', 'fs_week_schedule.break_start_time', 'fs_week_schedule.break_end_time',)
            ->join('fs_owner', 'fs_owner.id', '=', 'fs_week_schedule.restaurant_id')
            ->where('fs_week_schedule.restaurant_id', $id)
            ->get();

        return $query;
    }
}
