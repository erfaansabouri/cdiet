<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller {
    /**
     * @OA\Get(
     *     path="/api/notifications/index",
     *     summary="Get list of notifications",
     *     tags={"Notifications"},
     *     	 @OA\Parameter(
     *         description="page",
     *         in="query",
     *         name="page",
     *         required=false,
     *
     *         @OA\Schema(type="integer"),
     *     ),
     *
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     *     @OA\Response(response=422, description="Unprocessable Content", @OA\JsonContent()),
     *     security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */
    public function index ( Request $request ) {
        $user = Auth::user();
        $notifications = $user->notifications()
                              ->latest()
                              ->simplePaginate(12);

        return response()->json([
                                    'notifications' => NotificationResource::collection($notifications) ,
                                ]);
    }

    /**
     * @OA\Put(
     *     path="/api/notifications/read/{id}",
     *     summary="Mark a notification as read",
     *     tags={"Notifications"},
     *     	 @OA\Parameter(
     *         description="id",
     *         in="path",
     *         name="id",
     *         required=true,
     *
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     *     @OA\Response(response=422, description="Unprocessable Content", @OA\JsonContent()),
     *     security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */
    public function read ( $id ) {
        $user = Auth::user();
        $notification = $user->unreadNotifications()
                             ->where('id' , $id)
                             ->first();
        if ( $notification instanceof DatabaseNotification ) {
            $notification->markAsRead();

            return util()->simpleSuccess('اعلان خوانده شد.');
        }

        return util()->throwError('اعلان یافت نشد.');
    }
}
