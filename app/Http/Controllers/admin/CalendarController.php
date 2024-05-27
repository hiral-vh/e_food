<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Interfaces\admin\CalendarRepositoryInterface;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    protected $calendarRepository = "";

    public function __construct(CalendarRepositoryInterface $calendarRepository)
    {
        $this->calendarRepository = $calendarRepository;
    }

    public function index()
    {
        return view('admin.calendar.calendar');
    }

    public function table_report($id)
    {
        $data['event'] = $this->calendarRepository->getEventBYid($id);

        return view('admin.calendar.calendar_report', $data);
    }

    public function calendarEvent(Request $request)
    {
        $event = $this->calendarRepository->getEvent($request);
        $event1 = $this->calendarRepository->getEventCount($request);

        $valuearray = array();
        if (count($event) > 0) {
            foreach ($event as $value) {
                $value->fromtime = '';
                $value->totimee = '';
                if (!empty($value->tableTime)) {
                    $value->fromtime = ($value->tableTime['time_from']) ? $value->tableTime['time_from'] : '';
                    $value->totimee = ($value->tableTime['time_to']) ? $value->tableTime['time_to'] : '';
                }

                $value->startdate = $value->book_date;
                $value->start = $value->startdate . ' ' . $value->fromtime;

                $valuearray[] = $value;
            }
        }

        $response = ['totalRecord' => $event1];

        return $response;
    }

    public function calendarEventUsers(Request $request)
    {
        $event = $this->calendarRepository->getEventUsers($request);
        return response()->json($event);
    }

    public function calendarTableList()
    {
        $data['event'] = $this->calendarRepository->getEventBYAll();

        return view('admin.calendar.calendar_table', $data);
    }
}
