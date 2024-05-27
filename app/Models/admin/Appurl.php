<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appurl extends Model
{
    use HasFactory;
    protected $guarded = ['id']; 
    protected $table = 'fs_url_app';
}
