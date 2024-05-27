<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Interfaces\admin\FoodcategotyRepositoryInterface;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class FoodCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $foodCategoryRepository = "";

    public function __construct(FoodcategotyRepositoryInterface $foodCategoryRepository)
    {
        $this->foodCategoryRepository = $foodCategoryRepository;
    }



    public function index()
    {
        return view('admin.food-category.index');
    }

    public function getFoodCategoryData(Request $request)
    {

        return $this->foodCategoryRepository->getDataFoodCategory($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.food-category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'food_category_name' => 'required',
            'food_category_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $foodCategory = $this->foodCategoryRepository->storeFoodCategory($request);
        if ($foodCategory) {
            Session::flash('success', 'Successfully Inserted');
            return redirect()->route('food-category.index');
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
        $data['category'] = $this->foodCategoryRepository->getSingleFoodCategory($id);
        return view('admin.food-category.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['category'] = $this->foodCategoryRepository->getSingleFoodCategory($id);
        return view('admin.food-category.edit', $data);
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
        $updateCategory = $this->foodCategoryRepository->updateFoodCategory($request, $id);
        if ($updateCategory) {
            Session::flash('success', 'Successfully Updated');
            return redirect()->route('food-category.index');
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
        $destroyCategory = $this->foodCategoryRepository->destroyFoodCategory($id);
        if ($destroyCategory) {
            Session::flash('success', 'Successfully Deleted');
            return redirect()->route('food-category.index');
        }
    }
}
