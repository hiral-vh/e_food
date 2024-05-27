<?php

namespace App\Http\Controllers\admin;

use App\Models\admin\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Interfaces\admin\FoodVideoRepositoryInterface;
use App\Repositories\admin\FoodVideoRepository;


class FoodVideoController extends Controller
{

    protected $foodVideoRepository = "";

    public function __construct(FoodVideoRepositoryInterface $foodVideoRepository)
    {
        $this->foodVideoRepository = $foodVideoRepository;
    }


    public function index()
    {
        $data['list'] = $this->foodVideoRepository->getVideos();
        return view('admin.food-video.index', $data);
    }

    public function viewDetails($id)
    {
        $data['details'] = $this->foodVideoRepository->getVideoById($id);
        return view('admin.food-video.show', $data);
    }
}
