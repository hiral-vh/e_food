<?php 

namespace App\Interfaces\admin;

use Illuminate\Http\Request;

interface DeliveryPersonRepositoryInterface {

    public function getDatadeliveryPerson(Request $request);
    public function storedeliveryPerson(Request $request);
    public function updatedeliveryPersoninorder(Request $request);
    public function updatedeliveryPerson(Request $request,$id);
    public function checkPhoneno($phone);
    public function checkPhonenoByID($phone,$id);
    public function checkEmail($email);
    public function checkEmailBYid($email,$id);
    public function getSingledeliveryPerson($id);
    public function getOrderDatabyID($id);
    public function destroydeliveryPerson($id);
    public function getAlldeiveryperson();
    public function getOrderDatacheck($id, $estimated_arrival, $time);
}