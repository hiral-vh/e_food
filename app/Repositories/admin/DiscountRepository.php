<?php

namespace App\Repositories\admin;

use App\Http\Traits\ApiResponseTrait;
use App\Interfaces\admin\DiscountRepositoryInterface;
use App\Models\admin\Country;
use App\Models\admin\Deliveryperson;
use App\Models\admin\Discount;
use App\Models\admin\Ordermaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscountRepository implements DiscountRepositoryInterface
{
    
    public function getDiscount($id){
        return Discount::findorfail($id);
    }
    public function checkdiscountname($name){
        $restarantId = Auth::user()->restaurant_id;
        return Discount::where('discount_name', 'like', '%' . $name . '%')->where('restaurant_id', $restarantId)->whereNull('deleted_at')->first();
    }
    public function checkdiscountcode($code){
        $restarantId = Auth::user()->restaurant_id;
        return Discount::where('discount_code', 'like', '%' . $code . '%')->where('restaurant_id', $restarantId)->whereNull('deleted_at')->first();
    }
   public function checkPromocode($code, $restaurant_id){
        $dateCheck = date('Y-m-d');
        return Discount::where('discount_code',$code)->where('discount_start_date', '<=', $dateCheck)->where('discount_end_date', '>=', $dateCheck)->where('restaurant_id', $restaurant_id)->whereNull('deleted_at')->first();
    }
   
    public function storeDiscount(Request $request){
        $data = $request->all();
        
        $id = Auth::user()->id;
        $data['created_by'] = $id;
        $restarantId = Auth::user()->id;
        $data['restaurant_id'] = $restarantId;
        if($request->discount_type == 'Percentage'){
            $data['discount_percentage'] = $request->discount_percentage;
        }else{
            $data['discount_percentage'] = $request->discount_amount;
        }
        $data['discount_start_date'] = date("Y-m-d", strtotime($request->discount_start_date));
        $data['discount_end_date'] = date("Y-m-d", strtotime($request->discount_end_date));
        return Discount::create($data);
    }
    public function getDiscountdata(Request $request)
    {
        $searchName = $request->query('search_name');
        $search_code = $request->query('search_code');

        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', array(1, 'asc'));


        $sortcolumns = array(
            0 => 'fs_discount.discount_name',
        );

        $query = Discount::select('*')->RestaurantId();
        if (!empty($searchName)) {
            $query->where('discount_name', 'like', '%' . $searchName . '%');
        }
        if (!empty($search_code)) {
            $query->where('discount_code', 'like', '%' . $search_code . '%');
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
            $url = route("discount.show", $category->id);
            $nameAction = $category->discount_name != "" ? "<a href='" . $url . "'>" . $category->discount_name . "</a>" : 'N/A';
            
            $json['data'][] = [
                $no,
                $nameAction,
                $category->discount_code,
                $category->discount_type,
                $category->discount_percentage,
                date("d/m/Y",strtotime($category->discount_start_date)),
                date("d/m/Y",strtotime($category->discount_end_date)),
            ];
            $no++;
        }
        return $json;
    }
    public function destroyDiscount($id)
    {
        $foodcategory = $this->getDiscount($id);
        $foodcategory->delete();
        return $foodcategory;
    }
    public function updateDiscount(Request $request, $id){
        $data = $request->all();
        $foodcategory = $this->getDiscount($id);
        $id = Auth::user()->id;
        $data['updated_by'] = $id;
        if ($request->discount_type == 'Percentage') {
            $data['discount_percentage'] = $request->discount_percentage;
        } else {
            $data['discount_percentage'] = $request->discount_amount;
        }
        $data['discount_start_date'] = date("Y-m-d", strtotime($request->discount_start_date));
        $data['discount_end_date'] = date("Y-m-d", strtotime($request->discount_end_date));
        $foodcategory->update($data);
        return $foodcategory;
    }
} 
