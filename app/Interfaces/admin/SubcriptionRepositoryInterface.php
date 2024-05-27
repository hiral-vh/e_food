<?php

namespace App\Interfaces\admin;

use Illuminate\Http\Request;

interface SubcriptionRepositoryInterface
{
    public function getAllsubscription();
    public function getSubscriptionDetails();
    public function getTrialSubscriptionDetails();
}
