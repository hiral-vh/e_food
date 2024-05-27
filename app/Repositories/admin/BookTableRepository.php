<?php

namespace App\Repositories\admin;

use App\Interfaces\admin\BookTableRepositoryInterface;
use App\Models\admin\BookTable;
use App\Models\admin\Owner;

use App\Models\admin\BookTableDuration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class  BookTableRepository implements BookTableRepositoryInterface
{

    public function storeBookTable(Request $request)
    {
        $data = $request->all();
        $restaurantId = auth()->guard('restaurantportal')->user()->id;


        $data['restaurant_id'] = $restaurantId;
        $data['created_by'] = Auth::user()->id;
        $booktable =  BookTable::create($data);

        $openingTime = auth()->guard('restaurantportal')->user()->restaurant_open_time;
        $closingTime = auth()->guard('restaurantportal')->user()->restaurant_close_time;
        if (empty($openingTime)) {
            return false;
        }
        $closingTimeCal = date('H', strtotime($closingTime));
        $opTime = date('H', strtotime($openingTime));
        $totalHours = intval($closingTimeCal - $opTime);
        $totalMin = intval($totalHours * 60);
        $slot = intval($totalMin / $booktable->duration);


        for ($i = 1; $i <= $slot; $i++) {

            $lastTm = "";
            if ($request->session()->has('lastTime')) {
                $lastTm = $request->session()->get('lastTime');
            }
            //    echo $i.':=> '.$lastTm.'<br/>';
            $timefrom = ($i == 1) ? $openingTime : $lastTm;

            $timetofinal = strtotime("+" . $booktable->duration . " minutes", strtotime($timefrom));
            $timeTo = date('H:i:s', $timetofinal);

            $request->session()->put('lastTime', $timeTo);
            $id = Auth::user()->id;
            $saveData = array(

                'book_table_id' => $booktable->id,
                'time_from' => $timefrom,
                'time_to' => $timeTo,
                'created_by' => $id,

            );
            $request->session()->flash('lastTime');
            $request->session()->put('lastTime', $timeTo);
            BookTableDuration::create($saveData);
        }
        return true;
    }

    public function updateBookTable(Request $request, $id)
    {
        $update =  $this->getSingleBookTable($id);
        $data = $request->all();
        $restaurantId = auth()->guard('restaurantportal')->user()->id;


        $data['restaurant_id'] = $restaurantId;
        $data['updated_by'] = Auth::user()->id;
        $update->update($data);

        $openingTime = auth()->guard('restaurantportal')->user()->restaurant_open_time;
        $closingTime = auth()->guard('restaurantportal')->user()->restaurant_close_time;
        if (empty($openingTime)) {
            return false;
        }
        $closingTimeCal = date('H', strtotime($closingTime));
        $opTime = date('H', strtotime($openingTime));
        $totalHours = intval($closingTimeCal - $opTime);
        $totalMin = intval($totalHours * 60);
        $slot = intval($totalMin / $update->duration);

        $duration = $this->getDurationBookTable($id);
        $duration->delete();
        for ($i = 1; $i <= $slot; $i++) {
            $lastTm = "";
            if ($request->session()->has('lastTime')) {
                $lastTm = $request->session()->get('lastTime');
            }

            $timefrom = ($i == 1) ? $openingTime : $lastTm;

            $timetofinal = strtotime("+" . $update->duration . " minutes", strtotime($timefrom));
            $timeTo = date('H:i:s', $timetofinal);


            $request->session()->put('lastTime', $timeTo);
            $updateData = array(
                'book_table_id' => $update->id,
                'time_from' => $timefrom,
                'time_to' => $timeTo,
                'updated_by' => Auth::user()->id,
            );
            $request->session()->flash('lastTime');
            $request->session()->put('lastTime', $timeTo);

            $duration->create($updateData);
        }
        return true;
    }

    public function getSingleBookTable($id)
    {
        return BookTable::findorfail($id);
    }

    public function getDurationBookTableData($id)
    {
        return BookTableDuration::where('book_table_id', $id)->get();
    }

    public function getDurationBookTable($id)
    {
        return BookTableDuration::where('book_table_id', $id);
    }


    public function getBookTableData(Request $request)
    {
        $searchName = $request->query('search_table_name');
        $searchNumberofPeople = $request->query('search_number_of_people');
        $searchDuration = $request->query('search_duration');

        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', array(1, 'asc'));


        $sortcolumns = array(
            0 => 'fs_book_table.table_name',
            1 => 'fs_book_table.number_of_people',
            2 => 'fs_book_table.duration',
        );

        $query = BookTable::with('tableDuration')->select('*')->where('restaurant_id', Auth::user()->id);

        if (!empty($searchName)) {
            $query->where('table_name', 'like', '%' . $searchName . '%');
        }
        if (!empty($searchNumberofPeople)) {
            $query->where('number_of_people', 'like', '%' . $searchNumberofPeople . '%');
        }
        if (!empty($searchDuration)) {
            $query->where('duration', 'like', '%' . $searchDuration . '%');
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

        $bookTable = $query->orderBy('created_at', 'desc')->get();
        $no =  $start + 1;
        foreach ($bookTable as $table) {
            $url = route("table-number.show", $table->id);
            $nameAction = $table->table_name != "" ? "<a href='" . $url . "'>" . $table->table_name . "</a>" : "<a href='" . $url . "'>N/A</a>";
            $numberOfPeople = $table->number_of_people;
            $duration = $table->duration;
            $json['data'][] = [
                $no,
                $nameAction,
                $numberOfPeople,
                $duration,
            ];

            $no++;
        }
        return $json;
    }

    public function destroyBookTable($id)
    {
        $booktable = $this->getSingleBookTable($id);

        $booktable->delete();

        return $booktable;
    }

    public function getTableList($restaurant_id)
    {
        return BookTable::where('restaurant_id', $restaurant_id)->whereNull('deleted_at')->orderBy('id', 'DESC')->get();
    }

    public function getTabledurationList($book_table_id)
    {
        return BookTableDuration::where('book_table_id', $book_table_id)->whereNull('deleted_at')->get();
    }
}
