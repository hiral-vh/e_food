<?php

namespace App\Interfaces\admin;

use Illuminate\Http\Request;

interface CalendarRepositoryInterface
{
    public function getEvent(Request $request);
    public function getEventCount(Request $request);
    public function getEventBYid($id);
    public function getEventBYAll();
    public function getEventUsers(Request $request);
}
