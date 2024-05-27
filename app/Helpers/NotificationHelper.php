<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Notification;
use App\DeviceToken;
use App\Helpers\WorkAssignHelper;
use Auth;
use Mail;

class NotificationHelper
{
    public static function pushToGoogle($arrayAndroidToken, $NotificationData)
    {
        $googleApiKey = 'AAAA52ktAv8:APA91bGnF11ukXKxxC1gZAvMfU_dQuuBVgkEkxCI4fTgrAmitrvuWWp5AoNzm0g3GyHoHDvQru5Xz6oex18YPF25KNtPwGrYFpQX-dwMRuwAnW4G9m4EZpfkKrNzMZvCHTI5ngayhPrg';
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array(
            'registration_ids' => $arrayAndroidToken,
            'data' => $NotificationData,
            'priority' => 'high',
            'notification' => $NotificationData,
        );
        $headers = array(
            'Authorization: key=' . $googleApiKey,
            'Content-Type: application/json',
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);


        curl_close($ch);
        return $result;
    }
}
