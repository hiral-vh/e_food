<?php

namespace App\Repositories\admin;

use App\Interfaces\admin\ProfileRepositoryInterface;
use App\Http\Traits\ImageUploadTrait;
use App\Models\admin\Cuisine;
use App\Models\admin\Owner;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileRepository implements ProfileRepositoryInterface
{
    use ImageUploadTrait;

    public function updateProfile(Request $request, $id)
    {
        $data = $request->all();
        $image = "";
        $foodcategory = $this->getSingleProfile($id);
        if ($request->hasFile('restaurant_document')) {
            $document = $this->uploadImage($request->file('restaurant_document'), 'restaurant_document');
        } else {
            $document = $foodcategory->restaurant_document;
        }
        /*$checkCuisns = Cuisine::whereRaw('cuisine_name LIKE "%' . $request->cuisine_id . '%"')->whereNull('deleted_at')->first();

       
        if ($checkCuisns) {
            $cuisine_id = $checkCuisns->id;
        } else {
            $insertARray = array(
                'cuisine_name' => $request->cuisine_id,
                'created_at' => date('Y-m-d H:i:s')
            );
            $insert = new Cuisine($insertARray);
            $insert->save();
            $cuisine_id = $insert->id;
        }*/

        if ($request->hasFile('restaurant_image')) {
            $image = $this->uploadImage($request->file('restaurant_image'), 'restaurant_image');
        } else {
            $image = $foodcategory->restaurant_image;
        }
        $id = Auth::user()->id;
        $restaurant_type = '';
        if ($request->restaurant_type != '') {
            $restaurant_type = implode(',', $request->restaurant_type);
        }
        $stripeflag = '0';
        if ($request->stripe_pk_key != '' && $request->stripe_sk_key != '') {
            $stripeflag = '1';
        }

        \Stripe\Stripe::setApiKey($request->stripe_sk_key);
        $response = '';
        try {
            // create a test customer to see if the provided secret key is valid
            $response = \Stripe\Customer::create(["description" => "Test Customer - Validate Secret Key"]);
        } catch (\Exception  $e) {
            return 0;
        }



        $data['restaurant_open_time'] = date("H:i:s", strtotime($request->restaurant_open_time));
        $data['restaurant_close_time'] = date("H:i:s", strtotime($request->restaurant_close_time));
        $data['restaurant_document'] = $document;
        $data['restaurant_image'] = $image;
        $data['restaurant_type'] = $restaurant_type;
        $data['stripe_pk_key'] = $request->stripe_pk_key;
        $data['stripe_sk_key'] = $request->stripe_sk_key;
        $data['stripeflag'] = $stripeflag;
        $data['cuisine_id'] = $request->cuisine_id;
        $data['updated_by'] = $id;
        $foodcategory->update($data);
        return $foodcategory;
    }


    public function getSingleProfile($id)
    {
        return Owner::findorfail($id);
    }
}
