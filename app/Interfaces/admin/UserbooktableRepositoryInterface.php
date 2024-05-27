<?php

namespace App\Interfaces\admin;

use Illuminate\Http\Request;

interface UserbooktableRepositoryInterface
{
    public function checkBookedtableornot($book_table_id, $restaurant_id, $booking_date, $currentTime,$time_id);
    public function checkBookedtableornotadd($book_table_id, $restaurant_id, $booking_date,$time_id);
    public function storeBooktable(Request $request);
    public function updatetableBooking(Request $request);
    public function updatetableBookingseated(Request $request);
    public function getBooktableWithdateandtime($currentDate, $currentTime,$userid);
    public function getRecordbyTime($book_table_time_id);
    public function getUserbooktableDataById($id);
    public function getUserBooktimetable();
}
