<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deliveryperson extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id']; 
    protected $dates = ['deleted_at'];
    protected $table = 'fs_delivery_person';

    public function scopeRestaurantId($q)
    {
        $restaurantId = auth()->guard('restaurantportal')->user()->id;
        $q->where('restaurant_id', $restaurantId);
    }
}
