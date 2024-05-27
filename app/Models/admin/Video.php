<?php

namespace App\Models\admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $timestamps = false;
    protected $table = 'video_master';
    public $guarded = ["id"];

    public static function findVideo($id)
    {
        $query = Video::find($id);
        return $query;
    }

    public static function getVideoByType($type)
    {
        $query = Video::where('type', $type)->orderBy('id', 'DESC')->paginate(10);
        return $query;
    }

    public static function getVideosByType()
    {
        $query = Video::where('type', 'restaurant')->get();
        return $query;
    }
}
