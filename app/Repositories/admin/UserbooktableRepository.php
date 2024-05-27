<?php

namespace App\Repositories\admin;

use App\Interfaces\admin\UserbooktableRepositoryInterface;
use App\Models\admin\BookTable;
use App\Models\admin\Owner;
use App\Models\admin\Userbooktable;
use App\Models\admin\BookTableDuration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\TotalOrderNotification;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;


class  UserbooktableRepository implements UserbooktableRepositoryInterface
{
    public function getUserBooktimetable()
    {
        $currentTime = date('H:i', strtotime('+5 minutes'));
        $currentDate = date('Y-m-d');
        $query = Userbooktable::select('fs_user_book_table.*')
            ->with('booktime', function ($q) use ($currentTime) {
                $q->where('fs_book_table_duration.time_from', '>', $currentTime);
            })
            ->where('fs_user_book_table.book_date', $currentDate)
            ->where('fs_user_book_table.send_notification', '0')
            ->whereNull('fs_user_book_table.deleted_at')
            ->get();
        return $query;
    }
    public function getFiveHoursBookTable()
    {
        $currentTime = date('H:i', strtotime('+5 hours'));
       
        $currentDate = date('Y-m-d');
        $query = Userbooktable::select('fs_user_book_table.*')
            ->with('booktime', function ($q) use ($currentTime) {
                $q->where('fs_book_table_duration.time_from', '>', $currentTime);
            })
            ->where('fs_user_book_table.book_date', $currentDate)
            ->where('fs_user_book_table.send_notification', '0')
            ->whereNull('fs_user_book_table.deleted_at')
            ->get();
        return $query;
    }
    public function getOneDayBookTable()
    {
        $currentTime = date('H:i', strtotime('+24 hours'));
       
        $currentDate = date('Y-m-d', strtotime('+24 hours'));
        $query = Userbooktable::select('fs_user_book_table.*')
            ->with('booktime', function ($q) use ($currentTime) {
                $q->where('fs_book_table_duration.time_from', '>', $currentTime);
            })
            ->where('fs_user_book_table.book_date',$currentDate)
            ->where('fs_user_book_table.send_notification', '0')
            ->whereNull('fs_user_book_table.deleted_at')
            ->get();
        return $query;
    }
    public function getBooktableWithdateandtime($currentDate, $currentTime, $userid)
    {
        $query = Userbooktable::select('fs_user_book_table.*')
            ->with('booktime', function ($q) use ($currentTime) {
                $q->where('fs_book_table_duration.time_from', '>=', $currentTime);
            })
            ->where('fs_user_book_table.user_id', $userid)
            ->where('fs_user_book_table.book_date', '>=', $currentDate)
            ->whereNull('fs_user_book_table.deleted_at')
            ->orderBy('fs_user_book_table.id', 'desc')
            ->get();
        return $query;
    }
    public function getBookTableWithDateAndTimeAPI($currentDate,$currentTime,$userid)
    {
        $query = Userbooktable::select('fs_user_book_table.*')
            ->where('fs_user_book_table.user_id', $userid)
            ->where('fs_user_book_table.book_date', '>=', $currentDate)
            ->where('fs_user_book_table.book_time', '>=', $currentTime)
            ->whereNull('fs_user_book_table.deleted_at')
            ->orderBy('fs_user_book_table.id', 'desc')
            ->get();
        return $query;
    }
    public function checkBookedtableornot($book_table_id, $restaurant_id, $booking_date, $currentTime, $timeid)
    {
        $query = Userbooktable::select('fs_user_book_table.*')
            ->with('booktime', function ($q) use ($currentTime) {
                $q->where('fs_book_table_duration.time_from', '<=', $currentTime)->where('fs_book_table_duration.time_to', '>=', $currentTime);
            })->where('fs_user_book_table.book_table_id', $book_table_id)
            ->where('fs_user_book_table.book_table_time_id', $timeid)
            ->where('fs_user_book_table.restaurant_id', $restaurant_id)
            ->where('fs_user_book_table.book_date', $booking_date)
            ->whereNull('fs_user_book_table.deleted_at')
            ->get();
        return $query;
    }
    public function checkBookedtableornotadd($book_table_id, $restaurant_id, $booking_date, $timeid)
    {
        $query = Userbooktable::select('fs_user_book_table.*')
            ->where('fs_user_book_table.book_table_id', $book_table_id)
            ->where('fs_user_book_table.book_table_time_id', $timeid)
            ->where('fs_user_book_table.restaurant_id', $restaurant_id)
            ->where('fs_user_book_table.book_date', $booking_date)
            ->where('fs_user_book_table.table_status', '!=', 0)
            ->whereNull('fs_user_book_table.deleted_at')
            ->get();
        return $query;
    }
    public function getRecordbyTime($id)
    {
        return BookTableDuration::select('time_from')->where('id', $id)->whereNull('deleted_at')->first();
    }

    public function getUserbooktableDataById($id)
    {
        return Userbooktable::where('id', $id)->whereNull('deleted_at')->first();
    }

    public function updatetableBooking(Request $request)
    {
        $Auth = auth()->user();
        $updateArray = array(
            'book_table_id' => $request->book_table_id,
            'book_table_time_id' => $request->book_table_time_id,
            'book_date' => date("Y-m-d", strtotime($request->booking_date)),
            'book_time' => date("H:i:s", strtotime($request->booking_time)),
            'number_of_people' => $request->number_of_people,
            'booking_notes' => $request->booking_notes,
            'updated_by' => $Auth['id'],
            'updated_at' => date('Y-m-d H:i:s')
        );

        return Userbooktable::where('id', $request->id)->update($updateArray);
    }
    public function updatetableBookingseated(Request $request)
    {
        $Auth = auth()->user();
        $updateArray = array(
            'seated_flag' => $request->seated_flag,
            'updated_by' => $Auth['id'],
            'updated_at' => date('Y-m-d H:i:s')
        );

        return Userbooktable::where('id', $request->user_book_table_id)->update($updateArray);
    }
    public function storeBooktable(Request $request)
    {
        $Auth = auth()->user();
        $checkRecordexist = Userbooktable::whereNull('deleted_at')->orderBy('id', 'desc')->get();
        if (count($checkRecordexist) > 0) {
            $refID = $checkRecordexist[0]->booking_ref_id;
            $remChar = substr($refID, 11);
            $addmores = $remChar + 1;
            $lngth = strlen("" . $addmores);
            $strlen1 = 5 - $lngth;
            $zeroln = "";
            for ($i = 0; $i < $strlen1; $i++) {
                $zeroln = "0" . $zeroln;
            }
            $booking_ref_id = 'Ref' . date('Ymd') . $zeroln . $addmores;
        } else {
            $booking_ref_id = 'Ref' . date('Ymd') . '00001'; //Ref2020020700001
        }

        $insertArray = array(
            'user_id' => $Auth['id'],
            'book_date' => date("Y-m-d", strtotime($request->booking_date)),
            'book_time' => date("H:i:s",strtotime($request->booking_time)),
            'number_of_people' => $request->number_of_people,
            'restaurant_id' => $request->restaurant_id,
            'booking_notes' => $request->booking_notes,
            'booking_ref_id' => $booking_ref_id,
            'table_status' => 1,
            'created_by' => $Auth['id'],
            'created_at' => date('Y-m-d H:i:s')
        );

        $insert = Userbooktable::create($insertArray);

        // $ownerData = Owner::find($request->restaurant_id);
        // $tableDetails = BookTable::find($request->book_table_id);
       // $bookTableTime = BookTableDuration::find($request->book_table_time_id);

        //notification
        // $details = [
        //     "type" => 4,
        //     "userName" => $Auth['first_name'] . ' ' . $Auth['last_name'],
        //     "message" => 'has booked table',
        //     "tableName" => $tableDetails->table_name,
        //     "bookingDate" => 'for ' . date("Y-m-d", strtotime($request->booking_date)) . ' ' . $bookTableTime->time_from . ' to ' . $bookTableTime->time_to,
        // ];
        // $title = "Booked Table";
        // $message = $details['userName'].' '.$details['message'].' '.$details['tableName'].' '.$details['bookingDate'];
        // $icon = '/favicon.png';
        // Notification::send($ownerData, new TotalOrderNotification($details));
        // self::sendNotification($title,$message,$icon);
        //end

        return $insert;
    }
    public function sendNotification($title,$body,$icon)
    {

        $firebaseToken = Owner::whereNotNull('device_token')->pluck('device_token')->all();

        $SERVER_API_KEY = 'AAAAoPv4xeE:APA91bHmn0W0NgaTjc5IH3W__56V9co7xnP00ENYrKSXT1aSiJOPEUtinxDMGWP4xfLWMo-F0vGr_IRaR2OSFuupqcGfwhjWwCsakDO_WSpSVLpZnGE9B0CJuRiaJUub1t8w1OFvsZXW';


        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $title,
                "body" => $body,
                "icon" => $icon,
            ]
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        return $response;
    }
}
