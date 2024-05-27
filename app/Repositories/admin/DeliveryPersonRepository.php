<?php

namespace App\Repositories\admin;

use App\Http\Traits\ApiResponseTrait;
use App\Interfaces\admin\DeliveryPersonRepositoryInterface;
use App\Models\admin\Country;
use App\Models\admin\Deliveryperson;
use App\Models\admin\Ordermaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryPersonRepository implements DeliveryPersonRepositoryInterface
{
    public function getAlldeiveryperson(){
        $id = Auth::user()->id;
        return Deliveryperson::whereNull('deleted_at')->where('restaurant_id', $id)->get();
    }
    public function getOrderDatacheck($id, $estimated_arrival, $time){
        return Ordermaster::where('delivery_person_id',$id)->where('order_type','3')->whereBetween('order_date_time',[$estimated_arrival, $time])->whereNull('deleted_at')->get();
    }
    public function getSingledeliveryPerson($id){
        return Deliveryperson::findorfail($id);
    }
    public function getOrderDatabyID($id){
        return Ordermaster::findorfail($id);
    }
    public function checkPhoneno($phone_no)
    {
        return Deliveryperson::where('delivery_person_mobile', $phone_no)->whereNull('deleted_at')->first();
    }
    public function checkPhonenoByID($phone_no,$id)
    {
        return Deliveryperson::where('delivery_person_mobile', $phone_no)->where('id','!=', $id)->whereNull('deleted_at')->first();
    }
    public function checkEmail($email)
    {
        return Deliveryperson::where('delivery_person_email', $email)->whereNull('deleted_at')->first();
    }
    public function checkEmailBYid($email,$id)
    {
        return Deliveryperson::where('delivery_person_email', $email)->where('id','!=', $id)->whereNull('deleted_at')->first();
    }
    public function storedeliveryPerson(Request $request){
        $data = $request->all();
        
        $id = Auth::user()->id;
        $data['created_by'] = $id;
        $data['restaurant_id'] = $id;

        return Deliveryperson::create($data);
    }
    public function getDatadeliveryPerson(Request $request)
    {
        $searchName = $request->query('search_name');

        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', array(1, 'asc'));


        $sortcolumns = array(
            0 => 'fs_delivery_person.delivery_person_name',
        );

        $query = Deliveryperson::select('*')->RestaurantId();
        if (!empty($searchName)) {
            $query->where('delivery_person_name', 'like', '%' . $searchName . '%');
        }
        
        $recordstotal = $query->count();
        $sortColumnName = $sortcolumns[$order[0]['column']];

        $query

            ->take($length)
            ->skip($start);

        $json = array(
            'draw' => $draw,
            'recordsTotal' => $recordstotal,
            'recordsFiltered' => $recordstotal,
            'data' => [],
        );

        $foodcategory = $query->latest()->get();
        $no =  $start + 1;
        foreach ($foodcategory as $category) {
            $url = route("delivery-person.show", $category->id);
            $nameAction = $category->delivery_person_name != "" ? "<a href='" . $url . "'>" . $category->delivery_person_name . "</a>" : 'N/A';
            
            $json['data'][] = [
                $no,
                $nameAction,
                $category->delivery_person_email,
                "+".$category->delivery_person_country_code .' '. $category->delivery_person_mobile,
            ];
            $no++;
        }
        return $json;
    }
    public function destroydeliveryPerson($id)
    {
        $foodcategory = $this->getSingledeliveryPerson($id);
        $foodcategory->delete();
        return $foodcategory;
    }
    public function updatedeliveryPersoninorder(Request $request){
        return Ordermaster::where('id',$request->orderidd)->update(array('delivery_person_id' => $request->delivery_person, 'updated_at' => date('Y-m-d H:i:s')));
    }
    public function updatedeliveryPerson(Request $request, $id){
        $data = $request->all();
        
        $foodcategory = $this->getSingledeliveryPerson($id);
        
        $id = Auth::user()->id;
        $data['updated_by'] = $id;
        $foodcategory->update($data);
        return $foodcategory;
    }
} 
