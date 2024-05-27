<?php

namespace App\Repositories\admin;

use App\Http\Traits\ApiResponseTrait;
use App\Interfaces\admin\CountryRepositoryInterface;
use App\Models\admin\Country;
use Illuminate\Http\Request;

class CountryRepository implements CountryRepositoryInterface
{
    public function getCountry()
    {
        return Country::whereNull('deleted_at')->get();
    }
} 
