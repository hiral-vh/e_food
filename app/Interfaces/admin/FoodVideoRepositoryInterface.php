<?php

namespace App\Interfaces\admin;

use Illuminate\Http\Request;

interface FoodVideoRepositoryInterface
{
    public function getVideos();
    public function getVideoById($id);
}
