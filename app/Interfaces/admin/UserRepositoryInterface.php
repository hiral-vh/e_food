<?php 

namespace App\Interfaces\admin;

use Illuminate\Http\Request;

interface UserRepositoryInterface {
    public function storeUser(Request $request);
    public function updateProfile(Request $request);
    public function updateDevicetoken(Request $request);
    public function updateEmailaddress(Request $request);
    public function updateNewpassword(Request $request);
    public function addHelpsupportData(Request $request);
    public function storeUserdelievery_address(Request $request);
    public function recentlyVisitrestaurantsuser(Request $request);
    public function storeUsercardDetail($name_of_card,$cid, $customerJson);
    public function getUserdeliveryAddress($userid);
    public function getUserpaymentData($userid);
    public function checkEmailuser($email);
    public function checkEmailuserNotID($email);
    public function checkForgotOTPverify($id,$otp);
    public function getUsercardData($userid);
    public function mysavePlaces($userid);
    public function getByIddata($userid);
    public function mysavePlacesbySearch($userid, $searchvalue);
    public function getFAQdata();
    public function getCMSdata();
    public function getAlluser();
}