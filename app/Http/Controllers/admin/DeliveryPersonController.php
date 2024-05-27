<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Interfaces\admin\DeliveryPersonRepositoryInterface;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class DeliveryPersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $deliveryPersonRepository = "";

    public function __construct(DeliveryPersonRepositoryInterface $deliveryPersonRepository)
    {
        $this->deliveryPersonRepository = $deliveryPersonRepository;
    }



    public function index()
    {
        return view('admin.delivery-person.index');
    }

    public function getDeliverypersondata(Request $request)
    {

        return $this->deliveryPersonRepository->getDatadeliveryPerson($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.delivery-person.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getDeliveryperson(Request $request){
        $orderDeliverdatetime = $this->deliveryPersonRepository->getOrderDatabyID($request->orderid);
        $estimated_arrival = '';
        $estimated_arrivalend = '';
        if($orderDeliverdatetime){
            
            $time = date('H:i:s', strtotime($orderDeliverdatetime->order_date_time));
            $estimatedHour = date('H:i:s', strtotime($time . ' +' . $orderDeliverdatetime->estimated_min . ' minutes'));
            $estimated_arrival = date('Y-m-d H:i:s', strtotime($orderDeliverdatetime->order_date_time));
            $estimated_arrivalend = date("Y-m-d H:i:s", strtotime($estimatedHour));
        }
        $getDeliveryPerson = $this->deliveryPersonRepository->getAlldeiveryperson();
        $personArray = array();
        if(count($getDeliveryPerson) > 0){
            foreach($getDeliveryPerson as $key){
                $checkDeliverypersonaval = $this->deliveryPersonRepository->getOrderDatacheck($key->id, $estimated_arrival, $estimated_arrivalend);
                if(count($checkDeliverypersonaval) == 0){
                    $personArray[] = array('id' => $key->id, 'delivery_person_name' => $key->delivery_person_name);
                }
            }
        }
        
        echo json_encode($personArray);
    }
    public function addDeliverypersons(Request $request){
        $updateDelivery = $this->deliveryPersonRepository->updatedeliveryPersoninorder($request);
        if ($updateDelivery) {
            echo 1;
        }else{
            echo 0;
        }
    }

    public function check_deliveryperson_register_phone(Request $request){

        if ($request['id'] != '') {
            $query = $this->deliveryPersonRepository->checkPhonenoByID($request['phone_no'], $request['id']);
        } else {
            $query = $this->deliveryPersonRepository->checkPhoneno($request['phone_no']);
        }

        
        if ($query) {
            echo 0;
        } else {
            echo 1;
        }
    }
    public function check_deliveryperson_register_email(Request $request){
        if ($request['id'] != '') {
            $query = $this->deliveryPersonRepository->checkEmailBYid($request['delivery_person_email'], $request['id']);
        }else{
            $query = $this->deliveryPersonRepository->checkEmail($request['delivery_person_email']);
        }
        
        if ($query) {
            echo 0;
        } else {
            echo 1;
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'delivery_person_name' => 'required',
            'delivery_person_email' => 'required|email',
            'delivery_person_mobile' => 'required',
        ]);

        $foodCategory = $this->deliveryPersonRepository->storedeliveryPerson($request);
        if ($foodCategory) {
            Session::flash('success', 'Successfully Inserted');
            return redirect()->route('delivery-person.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['category'] = $this->deliveryPersonRepository->getSingledeliveryPerson($id);
        return view('admin.delivery-person.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['category'] = $this->deliveryPersonRepository->getSingledeliveryPerson($id);
        return view('admin.delivery-person.edit', $data);
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
        $updateCategory = $this->deliveryPersonRepository->updatedeliveryPerson($request, $id);
        if ($updateCategory) {
            Session::flash('success', 'Successfully Updated');
            return redirect()->route('delivery-person.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroyCategory = $this->deliveryPersonRepository->destroydeliveryPerson($id);
        if ($destroyCategory) {
            Session::flash('success', 'Successfully Deleted');
            return redirect()->route('delivery-person.index');
        }
    }
}
