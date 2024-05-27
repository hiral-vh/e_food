<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Interfaces\admin\DiscountRepositoryInterface;
use App\Models\admin\Foodmenusubcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $discountRepository = "";

    public function __construct(DiscountRepositoryInterface $discountRepository)
    {
        $this->discountRepository = $discountRepository;
    }

    public function getDiscountdata(Request $request)
    {
        return $this->discountRepository->getDiscountdata($request);
    }

    public function index()
    {
        return view('admin.discount.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('admin.discount.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $foodMenu = $this->discountRepository->storeDiscount($request);
        if ($foodMenu) {
            Session::flash('success', 'Successfully Inserted');
            return redirect()->route('discount.index');
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
        $data['discountData'] = $this->discountRepository->getDiscount($id);
        return view('admin.discount.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['menuEdit'] = $this->discountRepository->getDiscount($id);
        return view('admin.discount.edit', $data);
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
        $updateMenu = $this->discountRepository->updateDiscount($request, $id);
        if ($updateMenu) {
            Session::flash('success', 'Successfully Updated');
            return redirect()->route('discount.index');
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
        $destriyMenu = $this->discountRepository->destroyDiscount($id);
        if ($destriyMenu) {
            Session::flash('success', 'Successfully Deleted');
            return redirect()->route('discount.index');
        }
    }

    public function check_discount_name(Request $request){
        $query = $this->discountRepository->checkdiscountname($request['discount_name']);
        if ($query) {
            if($query->id != $request['id']){
                echo 0;
            }else{
                echo 1;
            }
            
        } else {
            echo 1;
        }
    }
    public function check_discount_code(Request $request){
        $query = $this->discountRepository->checkdiscountcode($request['discount_code']);
        if ($query) {
            if ($query->id != $request['id']) {
                echo 0;
            } else {
                echo 1;
            }
        } else {
            echo 1;
        }
    }
}
