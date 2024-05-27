<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;
use Config;
use Notification;
use Illuminate\Notifications\DatabaseNotification;
use App\Notifications\TotalOrderNotification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

        $this->data['notifications'] = auth()->user()->notifications;

        $notification = auth()->user()->notifications()->where('notifiable_id', auth()->user()->id)->whereNull('read_at')->get();
        $this->data['getNotifications'] = auth()->user()->notifications()->where('notifiable_id', auth()->user()->id)->get();


        if (count($notification) > 0) {
            $notification->markAsRead();
        }

        return view('admin.notification.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }
}
