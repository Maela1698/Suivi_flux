<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class ControllerNotification extends Controller
{
    public function getNotifications()
    {
        $notif = Notification::getAllNotification();
        return response()->json($notif);
    }
}
