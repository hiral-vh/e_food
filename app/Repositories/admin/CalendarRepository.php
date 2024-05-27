<?php

namespace App\Repositories\admin;

use App\Http\Traits\ApiResponseTrait;
use App\Interfaces\admin\CalendarRepositoryInterface;
use App\Models\admin\Country;
use App\Models\admin\Ordermaster;
use App\Models\admin\Userbooktable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CalendarRepository implements CalendarRepositoryInterface
{
    public function getEvent(Request $request)
    {
        $start = $request->start;
        $end = $request->end;
        $Auth = auth()->user();
        $userId = $Auth['id'];
        $query = Userbooktable::select('id', 'user_id', 'book_table_time_id', 'book_table_id', 'book_date', 'restaurant_id')->with('tableTime:id,time_from,time_to')->with('tableName')
            ->where('restaurant_id', $userId)
            ->whereBetween('book_date', [$start, $end])
            ->get();
        return $query;
    }
    // for total count record
    public function getEventCount(Request $request)
    {
        $start = $request->start;
        $end = $request->end;
        $Auth = auth()->user();
        $userId = $Auth['id'];

        $query = Userbooktable::select(DB::raw('DISTINCT DATE(book_date) AS book_date_val, COUNT(book_date) AS bookDateCount, fs_user_book_table.*'))
            ->with('tableTime:id,time_from,time_to')->with('tableName')
            ->where('restaurant_id', $userId)
            ->whereBetween('book_date', [$start, $end])
            ->groupBy('book_date_val')
            ->get();
        return $query;
    }
    //end
    public function getEventBYid($id)
    {
        $Auth = auth()->user();
        $userId = $Auth['id'];
        $query = Userbooktable::select('*')->with('tableTime:id,time_from,time_to')->with('tableName')->with('user:id,first_name,last_name,email,mobile_no,country_code')
            ->where('restaurant_id', $userId)
            ->where('book_date', $id)
            ->get();
        return $query;
    }

    public function getEventBYAll()
    {
        $userId = Auth::user()->id;
        $query = Userbooktable::select('*')->with('tableTime:id,time_from,time_to')->with('tableName')->with('user:id,first_name,last_name,email,mobile_no,country_code')
            ->where('restaurant_id', $userId)
            ->orderBy('book_date', 'desc')
            ->get();
        return $query;
    }


    public function getEventUsers(Request $request)
    {
        $id = $request->id;
        $Auth = auth()->user();
        $userId = $Auth['id'];
        $query = Userbooktable::select('id', 'user_id', 'booking_ref_id', 'book_table_time_id', 'book_date', 'restaurant_id')->with('tableTime:id,time_from,time_to')->with('tableName')->with('user:id,first_name,last_name')
            ->where('restaurant_id', $userId)
            ->where('id', $id)
            ->get();
        return $query;
    }
}
