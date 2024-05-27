<?php

namespace App\Repositories\admin;

use App\Http\Traits\ApiResponseTrait;
use App\Interfaces\admin\RestaurantRepositoryInterface;
use App\Http\Traits\ImageUploadTrait;
use App\Models\admin\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestaurantRepository implements RestaurantRepositoryInterface
{
    use ImageUploadTrait;
    public function storeRestaurantData(Request $request)
    {
       
        $data = $request->all();
        $image = "";
        if ($request->hasFile('restaurant_image')) {
            $image = $this->uploadImage($request->file('restaurant_image'), 'restaurant');
        }
        $id = Auth::user()->id;
        $data['restaurant_image'] = $image;
        $data['created_by'] = $id;
        $data['status'] = '1';
        return Restaurant::create($data);
    }

    public function updateRestaurantData(Request $request, $id)
    {
    }

    public function getRestaurantData(Request $request)
    {
    }

    public function deleteRestaurant($id)
    {
    }

    public function getSingleRestaurantData($id)
    {
    }
}
