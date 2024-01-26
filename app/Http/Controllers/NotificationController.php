<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getFlashNotifications(): JsonResponse
    {
        $notifications = Notification::where('user_id',auth()->user()->id)->orderBy('created_at','desc')->take(3)->get();

        return response()->json(['data' => $notifications]);
    }

    public function getAllNotifications(): JsonResponse
    {
        $notifications = Notification::where('user_id',auth()->user()->id)->orderBy('created_at','desc')->get();

        return response()->json(['data' => $notifications]);
    }

    public function getUnreadNotifications(): JsonResponse
    {
        $notifications = Notification::where('user_id',auth()->user()->id)->where('unread',false)->get();

        return response()->json(['data' => $notifications]);
    }

    public function setReadNotifications()
    {
        Notification::where('user_id',auth()->user()->id)->where('unread',false)->update([
            'unread' => true
        ]);
    }
}
