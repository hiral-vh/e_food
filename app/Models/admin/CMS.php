<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CMS extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id']; 
    protected $dates = ['deleted_at'];
    protected $table = 'fs_cms';
}
