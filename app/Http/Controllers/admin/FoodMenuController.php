<?php

namespace App\Http\Controllers\admin;

use App\Models\admin\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\admin\Foodmenusubcategory;
use App\Interfaces\admin\MenuRepositoryInterface;
use App\Repositories\admin\FoodcategotyRepository;
use App\Repositories\admin\MenuCategoryRepository;
use App\Interfaces\admin\FoodcategotyRepositoryInterface;

class FoodMenuController extends Controller
{

    protected $foodMenuRepository = "", $foodcategotyRepository = "";

    public function __construct(MenuRepositoryInterface $foodMenuRepository, FoodcategotyRepositoryInterface $foodcategotyRepository)
    {
        $this->foodMenuRepository = $foodMenuRepository;
        $this->foodcategotyRepository = $foodcategotyRepository;
    }

    public function getFoodMenuData(Request $request)
    {
        return $this->foodMenuRepository->getDataFoodMenu($request);
    }

    public function index(MenuCategoryRepository $menuCategory)
    {
        $data['menuData'] = $menuCategory->getMenuCategory();
        return view('admin.food-menu.index', $data);
    }


    public function create()
    {
        $data['foodData'] = $this->foodMenuRepository->getMenuData();
        return view('admin.food-menu.create', $data);
    }

    public function createFoodMenu(FoodcategotyRepository $foodCategory, $id)
    {
        $data['menuCategory'] = $foodCategory->getFoodCategorydata();
        $data['menu_category_id'] = $id;
        return view('admin.food-menu.create', $data);
    }


    public function store(Request $request)
    {
        $foodMenu = $this->foodMenuRepository->storeFoodMenu($request);
        if ($foodMenu) {
            Session::flash('success', 'Successfully Inserted');
            return redirect()->route('food-menu.index');
        }
    }


    public function show($id)
    {
        $data['menuData'] = $this->foodMenuRepository->getSingleFoodMenu($id);
        $data['menuDataAttibute'] = $this->foodMenuRepository->getSingleFoodMenuAttibute($id);
        $data['menuDataExtraItem'] = $this->foodMenuRepository->getSingleFoodMenuExtraItem($id);
        $data['removeIngredients'] = $this->foodMenuRepository->getRemoveIngredients($id);
        return view('admin.food-menu.show', $data);
    }


    public function edit(FoodcategotyRepository $foodCategory, $id)
    {
        $data['menuEdit'] = $this->foodMenuRepository->getSingleFoodMenu($id);
        $menu = $this->foodMenuRepository->getFoodMenusByName($data['menuEdit']->name);
        $categoryId = [];
        foreach ($menu as $value) {
            $categoryId[] = $value->category_id;
        }
        $data['categories'] = $categoryId;
        $data['menuCategory'] = $foodCategory->getFoodCategorydata();
        $data['menuDataAttibute'] = $this->foodMenuRepository->getSingleFoodMenuAttibute($id);
        $data['menuDataExtraItem'] = $this->foodMenuRepository->getSingleFoodMenuExtraItem($id);
        $data['removeIngredients'] = $this->foodMenuRepository->getRemoveIngredients($id);
        return view('admin.food-menu.edit', $data);
    }



    public function update(Request $request, $id)
    {
        $updateMenu = $this->foodMenuRepository->updateFoodMenu($request, $id);
        if ($updateMenu) {
            Session::flash('success', 'Successfully Updated');
            return redirect()->route('food-menu.index');
        }
    }

    public function destroy($id)
    {
        $destriyMenu = $this->foodMenuRepository->destroyFoodMenu($id);
        if ($destriyMenu) {
            Session::flash('success', 'Successfully Deleted');
            return redirect()->route('food-menu.index');
        }
    }

    public function updateStatus(Request $request)
    {
        $updateStatus = $this->foodMenuRepository->getUpdatedStatus($request);
        if ($updateStatus) {
            return response()->json(['success' => 'Status Update Successfully.']);
        }
    }
}
