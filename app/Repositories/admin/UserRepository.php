<?php

namespace App\Repositories\admin;

use App\Http\Traits\ApiResponseTrait;
use App\Interfaces\admin\UserRepositoryInterface;
use App\Models\admin\Userbooktable;
use App\Models\admin\Faq;
use App\Models\admin\User;
use App\Models\admin\CMS;
use App\Models\admin\Helpsupport;
use App\Models\admin\Userdeliveryaddress;
use App\Models\admin\Saverestaurant;
use App\Models\admin\Recentlyvisitrestaurant;
use App\Models\admin\Usercarddetail;
use Illuminate\Http\Request;
use Hash;
use DB;

class UserRepository implements UserRepositoryInterface
{
    public function storeUser(Request $request)
    {
        $password = Hash::make($request->password);
        $insertArray = array(
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'country_code' => $request->country_code,
            'mobile_no' => $request->mobile_no,
            'device_token' => $request->device_token,
            'password' => $password,
            'created_at' => date('Y-m-d H:i:s')
        );

        return User::create($insertArray);
    }
    public function storeUsercardDetail($name_of_card,$cid, $customerJson)
    {
        $user = auth()->user();
        $checkFirstData = Usercarddetail::where('user_id', $user['id'])->whereNull('deleted_at')->first();
        $defualt_flag = '0';
        if(!$checkFirstData){
            $defualt_flag = '1';
        }
        $insertArray = array(
            'user_id' => $user['id'],
            'name_of_card' => $name_of_card,
            'stripe_customer_id' => $cid,
            'customer_json' => json_encode($customerJson),
            'defualt_flag' => $defualt_flag,
            'created_at' => date('Y-m-d H:i:s')
        );

        return Usercarddetail::create($insertArray);
    }
    public function storeUserdelievery_address(Request $request)
    {
        $user = auth()->user();
        $checkStoreAddress = Userdeliveryaddress::where('user_id',$user['id'])->whereNull('deleted_at')->first();
        if($checkStoreAddress){
            $updateArray = array(
                'address_line' => $request->address_line,
                'address_street' => $request->address_street,
                'address_city' => $request->address_city,
                'address_postcode' => $request->address_postcode,
                'address_country_code' => $request->address_country_code,
                'address_contact_no' => $request->address_contact_no,
                'updated_by' => $user['id'],
                'updated_at' => date('Y-m-d H:i:s')
            );
            $update = Userdeliveryaddress::where('id', $checkStoreAddress->id)->update($updateArray);
            return $update;
        }else{
            $insertArray = array(
                'user_id' => $user['id'],
                'address_line' => $request->address_line,
                'address_street' => $request->address_street,
                'address_city' => $request->address_city,
                'address_postcode' => $request->address_postcode,
                'address_country_code' => $request->address_country_code,
                'address_contact_no' => $request->address_contact_no,
                'created_at' => date('Y-m-d H:i:s')
            );
            return Userdeliveryaddress::create($insertArray);
        }

    }
    public function updateProfile(Request $request){
        $user = auth()->user();
        $profilephoto = '';
        if ($request->hasfile('profilephoto')) {
            $file = $request->file('profilephoto');
            $name = $file->getClientOriginalName();
            $name = str_replace(" ", "", time() . $name);
            $file->move(public_path() . '/upload/user/', $name);
            $profilephoto = '/upload/user/' . $name;
        }
        $updateArray = array(
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'mobile_no' => $request->mobile_no,
            'country_code' => $request->country_code,
            'profile_photo_path' => $profilephoto,
            'updated_at' => date('Y-m-d H:i:s')
        );
        return User::where('id', $user['id'])->update($updateArray);
    }
    public function updateDevicetoken(Request $request){
        $user = auth()->user();
        $updateArray = array(
            'device_token' => $request->device_token,
            'updated_at' => date('Y-m-d H:i:s')
        );
        return User::where('id', $user['id'])->update($updateArray);
    }
    public function addHelpsupportData(Request $request){
        $user = auth()->user();
        $insertArray = array(
            'user_id' => $user['id'],
            'full_name' => $request->full_name,
            'email' => $request->email,
            'message' => $request->message,
            'created_by' => $user['id'],
            'created_at' => date('Y-m-d H:i:s')
        );
        return Helpsupport::create($insertArray);
    }
    public function updateEmailaddress(Request $request){
        $user = auth()->user();
        $updateArray = array(
            'email' => $request->email,
            'updated_at' => date('Y-m-d H:i:s')
        );
        return User::where('id', $user['id'])->update($updateArray);
    }
    public function recentlyVisitrestaurantsuser(Request $request){
        $user = auth()->user();
        $userBooktabledata = Userbooktable::where('id', $request->user_book_table_id)->whereNull('deleted_at')->first();
        if($userBooktabledata){
            $insertArray = array(
                'restaurant_id' => $userBooktabledata->restaurant_id,
                'user_id' => $user['id'],
                'visit_date_time' => date('Y-m-d H:i:s'),
                'created_by' => $user['id'],
                'created_at' => date('Y-m-d H:i:s')
            );
            return Recentlyvisitrestaurant::create($insertArray);
        }
    }
    public function updateNewpassword(Request $request){
        $user = auth()->user();
        $updateArray = array(
            'password' => Hash::make($request->new_password),
            'updated_at' => date('Y-m-d H:i:s')
        );
        return User::where('id', $user['id'])->update($updateArray);
    }
    public function checkEmailuser($email){
        return User::where('email',$email)->where('active','1')->whereNull('deleted_at')->first();
    }
    public function getAlluser(){
        return User::select('id',DB::raw('CONCAT(first_name, " ", last_name) AS full_name'))->where('active','1')->whereNull('deleted_at')->pluck('full_name', 'id')->all();
    }
    public function checkEmailuserNotID($email){
        $user = auth()->user();
        return User::where('email',$email)->where('id','!=', $user['id'])->where('active','1')->whereNull('deleted_at')->first();
    }
    public function getByIddata($id){
        return User::where('id',$id)->where('active','1')->whereNull('deleted_at')->first();
    }
    public function checkForgotOTPverify($id, $otp){
        return User::where('id',$id)->where('otp', $otp)->where('active','1')->whereNull('deleted_at')->first();
    }
    public function getUsercardData($id){
        return Usercarddetail::where('user_id',$id)->whereNull('deleted_at')->orderBy('id','desc')->get();
    }
    public function getUserdeliveryAddress($id){
        return Userdeliveryaddress::where('user_id',$id)->whereNull('deleted_at')->first();
    }
    public function getUserpaymentData($id){
        return Usercarddetail::where('user_id',$id)->where('defualt_flag','1')->whereNull('deleted_at')->first();
    }
    public function getFAQdata(){
        return Faq::whereNull('deleted_at')->get();
    }
    public function getCMSdata(){
        return CMS::whereNull('deleted_at')->get();
    }
    public function mysavePlaces($user_id){
        $query = Saverestaurant::select(
            'fs_save_restaurant.*'
        )

            ->where('fs_save_restaurant.user_id', $user_id)
            ->whereNull('fs_save_restaurant.deleted_at')
            ->get();
        return $query;
    }
    public function mysavePlacesbySearch($user_id, $searchvalue){
        $query = Saverestaurant::select(
            'fs_save_restaurant.*'
        )
            ->leftJoin('fs_owner', function ($join) {
                $join->on(
                'fs_save_restaurant.restaurant_id',
                    '=',
                'fs_owner.id'
                );
            })
            ->whereRaw('lower(fs_owner.restaurant_name) like (?)', ["%{$searchvalue}%"])
            ->where('fs_save_restaurant.user_id', $user_id)
            ->whereNull('fs_save_restaurant.deleted_at')
            ->get();
        return $query;
    }
}
