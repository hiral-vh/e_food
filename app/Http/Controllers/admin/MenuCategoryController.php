<?php
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Interfaces\admin\MenuCategoryRepositoryInterface;

class MenuCategoryController extends Controller
{
     protected $menuCategoryRepository = "";

    public function __construct(MenuCategoryRepositoryInterface $menuCategoryRepository)
    {
        $this->menuCategoryRepository=$menuCategoryRepository;
    }

    public function index()
    {
        return view('admin.menu-category.index');
    }

    public function create()
    {
        return view('admin.menu-category.create');
    }


    public function store(Request $request)
    {
        $menuCategory = $this->menuCategoryRepository->storeMenuCategory($request);
        if ($menuCategory) {
            Session::flash('success', 'Successfully Inserted');
            return redirect()->route('menu-category.index');
        }
    }


    public function show($id)
    {
        $data['menuCategory'] = $this->menuCategoryRepository->getSingleMenuCategory($id);
        return view('admin.menu-category.show', $data);
    }

    public function edit($id)
    {
        $data['menuCategory'] = $this->menuCategoryRepository->getSingleMenuCategory($id);
        return view('admin.menu-category.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $updateMenuCategory = $this->menuCategoryRepository->updateMenuCategory($request,$id);
        if ($updateMenuCategory) {
            Session::flash('success', 'Successfully Updated');
            return redirect()->route('menu-category.index');
        }
    }

    public function destroy($id)
    {
        $destroyMenuCategory = $this->menuCategoryRepository->destroyMenuCategory($id);
        if ($destroyMenuCategory) {
            Session::flash('success', 'Successfully Deleted');
            return redirect()->route('menu-category.index');
        }
    }

    public function getMenuCategoryData(Request $request)
    {
        return $this->menuCategoryRepository->getMenuCategoryTableData($request);
    }

}
