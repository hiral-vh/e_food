<?php

namespace App\Repositories\admin;

use App\Http\Traits\ApiResponseTrait;
use App\Interfaces\admin\FoodVideoRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\admin\Video;

class FoodVideoRepository implements FoodVideoRepositoryInterface
{
    public function getVideos()
    {
        return Video::getVideosByType();
    }
    public function getVideoById($id)
    {
        return Video::findVideo($id);
    }
}
