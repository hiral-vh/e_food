<?php

namespace App\Repositories\admin;

use App\Http\Traits\ApiResponseTrait;
use App\Interfaces\admin\OrderitemmasterRepositoryInterface;
use App\Models\admin\Country;
use Illuminate\Http\Request;

class OrderitemmasterRepository implements OrderitemmasterRepositoryInterface
{
    public function getCountry()
    {
        return Country::whereNull('deleted_at')->get();
    }
} 
