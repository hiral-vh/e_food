<?php

namespace App\Repositories\admin;

use App\Http\Traits\ApiResponseTrait;
use App\Interfaces\admin\SubcriptionRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\admin\Subcription;
use App\Models\admin\Ownerrecuringhistory;
use Illuminate\Support\Facades\Auth;

class SubcriptionRepository implements SubcriptionRepositoryInterface
{
    public function getAllsubscription()
    {
        return Subcription::where("type", "restaurant")->whereNull('deleted_at')->orderBy('id', 'asc')->get();
    }

    public function getSubscriptionDetails()
    {
        $id = Auth::user()->id;
        $query = Subcription::getSubscription($id)->first();
        return $query;
    }

    public function getTrialSubscriptionDetails()
    {
        $id = Auth::user()->id;
        $query = Ownerrecuringhistory::getTrialSubscription($id)->first();
        return $query;
    }
}
