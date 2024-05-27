<?php

namespace App\Interfaces\admin;

use Illuminate\Http\Request;

interface BookTableRepositoryInterface
{
    public function storeBookTable(Request $request);

    public function updateBookTable(Request $request, $id);

    public function destroyBookTable($id);

    public function getSingleBookTable($id);

    public function getTableList($restaurant_id);

    public function getTabledurationList($book_table_id);

    public function getBookTableData(Request $request);

    public function getDurationBookTableData($id);
}
