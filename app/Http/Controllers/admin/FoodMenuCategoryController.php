<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Interfaces\admin\FoodmenucategoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FoodMenuCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $foodMenuCategoryRepository = "";

    public function __construct(FoodmenucategoryRepositoryInterface $foodMenuCategoryRepository)
    {
        $this->foodMenuCategoryRepository = $foodMenuCategoryRepository;
    }

    public function getMenuCategoryData(Request $request)
    {
        return $this->foodMenuCategoryRepository->getDataFoodMenuCategory($request);
    }

    public function index()
    {
        return view('admin.food-menu-category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.food-menu-category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $foodCategory = $this->foodMenuCategoryRepository->storeFoodMenuCategory($request);
        if ($foodCategory) {
            Session::flash('success', 'Successfully Inserted');
            return redirect()->route('food-menu-category.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['category'] = $this->foodMenuCategoryRepository->getSingleFoodMenuCategory($id);
        return view('admin.food-menu-category.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['subCategory'] = $this->foodMenuCategoryRepository->getMultipleFoodMenuCategory($id);
        $data['category'] = $this->foodMenuCategoryRepository->getSingleFoodMenuCategory($id);
        return view('admin.food-menu-category.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $updateCategory = $this->foodMenuCategoryRepository->updateFoodMenuCategory($request, $id);
        if ($updateCategory) {
            Session::flash('success', 'Successfully Updated');
            return redirect()->route('food-menu-category.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroyCategory = $this->foodMenuCategoryRepository->destroyFoodMenuCategory($id);
        if ($destroyCategory) {
            Session::flash('success', 'Successfully Deleted');
            return redirect()->route('food-menu-category.index');
        }
    }
}
