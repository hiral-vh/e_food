<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Interfaces\admin\CuisineRepositoryInterface;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class CuisineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $cuisineRepository = "";

    public function __construct(CuisineRepositoryInterface $cuisineRepository)
    {
        $this->cuisineRepository = $cuisineRepository;
    }



    public function index()
    {
        return view('admin.cuisine.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.cuisine.create');
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
            'cuisine_name' => 'required',
        ]);

        $foodCategory = $this->cuisineRepository->storeCuisine($request);
        if ($foodCategory) {
            Session::flash('success', 'Successfully Inserted');
            return redirect()->route('cuisine.index');
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
        $data['cuisine'] = $this->cuisineRepository->getSingleCuisine($id);
        return view('admin.cuisine.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['cuisine'] = $this->cuisineRepository->getSingleCuisine($id);
        return view('admin.cuisine.edit', $data);
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
        $updateCategory = $this->cuisineRepository->updateCuisine($request, $id);
        if ($updateCategory) {
            Session::flash('success', 'Successfully Updated');
            return redirect()->route('cuisine.index');
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
        $destroyCategory = $this->cuisineRepository->destroyCuisine($id);
        if ($destroyCategory) {
            Session::flash('success', 'Successfully Deleted');
            return redirect()->route('food-category.index');
        }
    }

    public function getCuisineData(Request $request)
    {
        return $this->cuisineRepository->getCuisineTableData($request);
    }
}
