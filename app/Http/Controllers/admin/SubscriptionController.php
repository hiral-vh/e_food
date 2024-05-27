<?php

namespace App\Http\Controllers\admin;

use App\Models\admin\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\admin\Foodmenusubcategory;
use App\Repositories\admin\SubcriptionRepository;
use App\Interfaces\admin\SubcriptionRepositoryInterface;

class SubscriptionController extends Controller
{

    protected $foodMenuRepository = "", $subcriptionRepository = "";

    public function __construct(SubcriptionRepositoryInterface $subcriptionRepository)
    {
        $this->subcriptionRepository = $subcriptionRepository;
    }

    public function index()
    {
        $data['subscriptionData'] = $this->subcriptionRepository->getSubscriptionDetails();
       
        if ($data['subscriptionData'] == null || $data['subscriptionData'] == '') {
         
            $data['subscriptionData'] = $this->subcriptionRepository->getTrialSubscriptionDetails();
        }
      
      

        return view('admin.subscription.show', $data);
    }
}
