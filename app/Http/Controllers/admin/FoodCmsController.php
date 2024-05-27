<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class FoodCmsController extends Controller
{
    public function index()
    {
        return view('admin.privacy-policy');
    }
    public function list()
    {
        return view('admin.cookies');
    }
    public function terms()
    {
        return view('admin.terms');
    }
}
