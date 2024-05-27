<?php

namespace App\Http\Controllers\admin;

use App\Models\admin\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\admin\WeekTimeSetting;
use App\Models\admin\Owner;
use Illuminate\Support\Facades\Auth;

class WeekTImeSettingController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $data['days'] = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
        $dayArr = [];

        $bussinessDay = WeekTimeSetting::where('restaurant_id', $user->id)->get();
        if (count($bussinessDay)) {

            foreach ($bussinessDay as $tt) {
                $dayArr[$tt->day][] = $tt;
            }
        }
        $data['dayArr'] = $dayArr;
        $data['time'] = Owner::where('id', $user->id)->first();

        return view('admin.week_time.index', $data);
    }

    public function store(Request $request)
    {
        $insert = WeekTimeSetting::updateOrCreate(
            [
                'restaurant_id'   => $request->restaurantId,
                'day'   => $request->day,
            ],
            [
                'open_time'     => $request->open_time,
                'close_time'     => $request->close_time,
                'break_start_time' => $request->break_start_time,
                'break_end_time' => $request->break_end_time,
                'created_at' => now()
            ],
        );

        if ($insert) {
            Session::flash('success', 'Week Schedule update Successfully');
            return redirect()->back();
        } else {
            Session::flash('error', 'Something went wrong');
            return redirect()->back();
        }
    }
}
