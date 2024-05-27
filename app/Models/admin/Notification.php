<?php

namespace App\Models\admin;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Authenticatable
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id']; 
    protected $dates = ['deleted_at'];
    protected $table = 'fs_notification';

    public static  function insert($data)
    {
        $Auth = auth()->user();
        $data['created_at'] = date('Y-m-d H:i:s');
        if ($Auth) {
            $data['created_by'] = $Auth['id'];
        }

        $insert = new Notification($data);
        $insert->save();
        $insertId = $insert->id;
        return $insertId;
    }
}
