<?php

namespace App\Interfaces\admin;

use Illuminate\Http\Request;

interface LoginRepositoryInterface
{

    public function checkForgotEmail($email);
    public function checkForgotPhoneno($phone);
    public function checkForgotBusinessnumber($business_number);
    public function getbyOTP($otpchange);
    public function getBooktableTime($timeid);
    public function updateAdmin($email, $data);
    public function getRestaurantDetailbyRestaurant($restaurant_id);
    public function getRestaurantDetailnearYou($live_lattitude, $live_longitude, $distance);
    public function getRestaurantDetailByfilter($live_lattitude, $live_longitude, $cuisine_id, $price, $distance);
    public function getResturentByfoodType($live_lattitude, $live_longitude, $food_type, $distance);
    public function getAllvenue();
    public function getAppuerList(Request $request);
    public function insertOwnerdata(Request $request);
    public function updateAdminpassword(Request $request);
    public function getAllvenueseachbyName($name);
    public function getAllorders($id);
    public function getTables($id);
    public function getUserbooktableorder($id);
    public function gettotalMonthlyordersRev($id);
    public function getWeekSchedule($id);
}
