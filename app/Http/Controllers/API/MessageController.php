<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;
use App\Http\Resources\PlanResource;
use App\Models\Message;
use App\Models\Plan;
use App\Services\GrokService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller {
    /**
     * @OA\Get(
     *     path="/api/messages/index",
     *     summary="Get messages",
     *     tags={"Messages"},
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
        $messages = Message::query()
                           ->where('user_id' , $user->id)
                           ->get();

        return response()->json([
                                    'messages' => MessageResource::collection($messages) ,
                                ]);
    }

    /**
     * @OA\Post(
     *     path="/api/messages/send",
     *     summary="Get messages",
     *     tags={"Messages"},
     *     @OA\Parameter(
     *          description="content",
     *          in="query",
     *          name="content",
     *          required=true,
     *
     *          @OA\Schema(type="string"),
     *      ),
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
    public function send ( Request $request ) {
        $request->validate([
                               'content' => 'required|string|max:1000' ,
                           ]);
        $user = Auth::user();
        Message::query()
               ->create([
                            'user_id' => $user->id ,
                            'role' => Message::ROLE[ 'user' ] ,
                            'content' => $request->get('content') ,
                        ]);
        $assistant_message = ( new GrokService() )->sendMessage($user->id , $request->get('content'));
        $message = Message::query()
                          ->create([
                                       'user_id' => $user->id ,
                                       'role' => Message::ROLE[ 'assistant' ] ,
                                       'content' => $assistant_message ,
                                   ]);

        return response()->json([
                                    'message' => MessageResource::make($message) ,
                                ]);
    }
}
