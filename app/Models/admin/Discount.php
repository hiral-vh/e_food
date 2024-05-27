<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id']; 
    protected $dates = ['deleted_at'];
    protected $table = 'fs_discount';

    public static  function insert($data)
    {
        $Auth = auth()->user();
        $data['created_at'] = date('Y-m-d H:i:s');
        if ($Auth) {
            $data['created_by'] = $Auth['id'];
        }

        $insert = new Discount($data);
        $insert->save();
        $insertId = $insert->id;
        return $insertId;
    }
    public function scopeRestaurantId($q)
    {
        $restaurantId = auth()->guard('restaurantportal')->user()->id;
        $q->where('restaurant_id', $restaurantId);
    }
}
