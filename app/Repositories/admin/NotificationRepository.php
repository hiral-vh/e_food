<?php

namespace App\Repositories\admin;

use App\Http\Traits\ApiResponseTrait;
use App\Interfaces\admin\NotificationRepositoryInterface;
use App\Models\admin\Notification;
use Illuminate\Http\Request;

class NotificationRepository implements NotificationRepositoryInterface
{
    public function getNotificationData($user_id)
    {
        return Notification::where('user_id', $user_id)->where('read_flag', '0')->whereNull('deleted_at')->orderBy('id', 'DESC')->get();
    }
    public function storeNotification($insertArray)
    {
        return Notification::create($insertArray);
    }
}
