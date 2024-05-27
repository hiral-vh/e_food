<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Interfaces\admin\BookTableRepositoryInterface;
use App\Models\admin\BookTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BookTableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $bookTableRepository = "";

    public function __construct(BookTableRepositoryInterface $bookTableRepository)
    {
        $this->bookTableRepository = $bookTableRepository;
    }

    public function getTableData(Request $request)
    {

        return $this->bookTableRepository->getBookTableData($request);
    }

    public function index()
    {
        return view('admin.book-table.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.book-table.create');
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
            'table_name' => 'required',
            'number_of_people' => 'required|numeric',
            'duration' => 'required',
        ]);

        $storeBookTable = $this->bookTableRepository->storeBookTable($request);
        if ($storeBookTable) {
            Session::flash('success', 'Successfully Inserted');
            return redirect()->route('table-number.index');
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
        $data['bookTableDuration'] = $this->bookTableRepository->getDurationBookTableData($id);
        $data['booktable'] = $this->bookTableRepository->getSingleBookTable($id);
        return view('admin.book-table.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['editTable'] = $this->bookTableRepository->getSingleBookTable($id);
        return view('admin.book-table.edit', $data);
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
        $updateBookTable = $this->bookTableRepository->updateBookTable($request, $id);
        if ($updateBookTable) {
            Session::flash('success', 'Successfully Updated');
            return redirect()->route('table-number.index');
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
        $destoryBookTable = $this->bookTableRepository->destroyBookTable($id);
        if ($destoryBookTable) {
            Session::flash('success', 'Successfully Deleted');
            return redirect()->route('table-number.index');
        }
    }
}
