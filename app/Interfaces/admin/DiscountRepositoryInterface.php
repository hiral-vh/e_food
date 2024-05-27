<?php 

namespace App\Interfaces\admin;

use Illuminate\Http\Request;

interface DiscountRepositoryInterface {

    public function getDiscountdata(Request $request);
    public function storeDiscount(Request $request);
    public function updateDiscount(Request $request,$id);
    public function destroyDiscount($id);
    public function getDiscount($id);
    public function checkdiscountname($name);
    public function checkdiscountcode($code);
    public function checkPromocode($code,$resid);
    
}