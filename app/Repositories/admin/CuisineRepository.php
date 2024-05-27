<?php

namespace App\Repositories\admin;

use App\Http\Traits\ApiResponseTrait;
use App\Interfaces\admin\CuisineRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\admin\Cuisine;
use Illuminate\Support\Facades\Auth;

class CuisineRepository implements CuisineRepositoryInterface
{
    public function getCuisindata()
    {
        return Cuisine::whereNull('deleted_at')->get();
    }
    public function getCuisindataByID($id)
    {
        return Cuisine::where('id', $id)->whereNull('deleted_at')->first();
    }

    public function storeCuisine(Request $request)
    {
        $data = $request->all();
        $data['created_by'] = Auth::user()->id;
        return Cuisine::create($data);
    }

    public function updateCuisine(Request $request, $id)
    {
        $updateCuisine = $this->getSingleCuisine($id);
        $data = $request->all();
        $data['updated_by'] = Auth::user()->id;
        $updateCuisine->update($data);
        return $updateCuisine;
    }

    public function getCuisineTableData(Request $request)
    {
        $searchName = $request->query('search_cuisine_name');


        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', array(1, 'asc'));


        $sortcolumns = array(
            0 => 'fs_cuisine.cuisine_name',
        );

        $query = Cuisine::select('*');

        if (!empty($searchName)) {
            $query->where('cuisine_name', 'like', '%' . $searchName . '%');
        }

        $recordstotal = $query->count();
        $sortColumnName = $sortcolumns[$order[0]['column']];

        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $json = array(
            'draw' => $draw,
            'recordsTotal' => $recordstotal,
            'recordsFiltered' => $recordstotal,
            'data' => [],
        );

        $cuisineData = $query->orderBy('created_at', 'desc')->get();
        foreach ($cuisineData as $cuisine) {
            $url = route("cuisine.show", $cuisine->id);
            $nameAction = $cuisine->cuisine_name != "" ? "<a href='" . $url . "'>" . $cuisine->cuisine_name . "</a>" : 'N/A';

            $json['data'][] = [
                $nameAction,

            ];
        }
        return $json;
    }

    public function destroyCuisine($id)
    {
        $cuisineDestroy = $this->getSingleCuisine($id);

        $cuisineDestroy->delete();

        return $cuisineDestroy;
    }

    public function getSingleCuisine($id)
    {
        return Cuisine::findorfail($id);
    }
}
