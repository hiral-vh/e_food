<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\admin\ProfileRepositoryInterface;
use App\Interfaces\admin\CuisineRepositoryInterface;
use App\Models\admin\Owner;
use App\Models\admin\Appurl;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{

    protected $ProfileRepository = "", $cuisineRepository = "";

    public function __construct(ProfileRepositoryInterface $ProfileRepository, CuisineRepositoryInterface $cuisineRepository)
    {
        $this->ProfileRepository = $ProfileRepository;
        $this->cuisineRepository = $cuisineRepository;
    }
    public function index()
    {
        $id = Auth::user()->id;
        $data['userdata'] = $this->ProfileRepository->getSingleProfile($id);
        $data['geturldata'] = Appurl::first();
        $data['crusineData'] = $this->cuisineRepository->getCuisindata();
        return view('admin.profile', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //    
    }


    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        // return $request->all();
        $request->validate([
            'restaurant_name' => 'required',
            'owner_name' => 'required',
            'business_number' => 'required',
            'email' => 'required',
            'restaurant_aboutus' => 'required',
            'phone_no' => 'required',
            'address' => 'required',
            'pincode' => 'required',
            'restaurant_open_time' => 'required',
            'restaurant_close_time' => 'required',
        ]);

        $storeBookTable = $this->ProfileRepository->updateProfile($request, $id);
        if ($storeBookTable) {
            $update = Appurl::where('id', '1')->update(array('android_url' => $request->android_url, 'ios_url' => $request->ios_url, 'updated_at' => date('Y-m-d H:i:s')));
            Session::flash('success', 'Successfully Updated');
            return redirect()->back();
        } else {
            Session::flash('error', 'Stripe Key Invalid');
            return redirect()->back();
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
        //
    }
    public function check_admin_register_mobile(Request $request)
    {
        $mobile = request('mobile');
        $id = request('id');
        $checkAdminlogin = Owner::where('phone_no', $mobile)->where('id', '!=', $id)->first();
        if ($checkAdminlogin) {
            echo 0;
        } else {
            echo 1;
        }
    }
    public function check_admin_register_email(Request $request)
    {
        $email = request('email');
        $id = request('id');
        $checkAdminlogin = Owner::where('email', $email)->where('id', '!=', $id)->first();
        if ($checkAdminlogin) {
            echo 0;
        } else {
            echo 1;
        }
    }
    public function saveToken(Request $request)
    {
        $userId = Auth::user()->id;
        $update = Owner::where('id', $userId)->update(array('device_token' => $request->device_token));
        return response()->json(['token saved successfully.']);
    }
}
