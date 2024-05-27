<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usercart extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id']; 
    protected $dates = ['deleted_at'];
    protected $table = 'fs_user_cart_master';

    public static  function insert($data)
    {
        $Auth = auth()->user();
        $data['created_at'] = date('Y-m-d H:i:s');
        if ($Auth) {
            $data['created_by'] = $Auth['id'];
        }

        $insert = new Usercart($data);
        $insert->save();
        $insertId = $insert->id;
        return $insertId;
    }
    public function menudata()
    {
        return $this->hasOne(Menu::class, 'id', 'menu_id');
    }
}
