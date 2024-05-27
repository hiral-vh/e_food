<?php 

namespace App\Interfaces\admin;

use Illuminate\Http\Request;

interface NotificationRepositoryInterface {

    public function getNotificationData($user_id);
    public function storeNotification($insertArray);
}