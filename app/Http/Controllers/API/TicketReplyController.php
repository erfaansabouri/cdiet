<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TicketReplyResource;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use App\Models\TicketStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketReplyController extends Controller {
    /**
     * @OA\Get(
     *      path="/api/ticket-replies/index",
     *      tags={"Ticket replies"},
     *      summary="Ticket replies list",
     *     	 @OA\Parameter(
     *         description="ticket_id",
     *         in="query",
     *         name="ticket_id",
     *         required=false,
     *
     *         @OA\Schema(type="integer"),
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
    public function index ( Request $request ) {
        $request->validate([
                               'ticket_id' => [ 'required' ] ,
                           ]);
        $ticket = Ticket::query()
                        ->where('user_id' , Auth::user()->id)
                        ->where('id' , $request->get('ticket_id'))
                        ->firstOrFail();
        $ticket_replies = $ticket->ticketReplies()
                                 ->get();

        return response()->json([
                                    'ticket' => TicketResource::make($ticket) ,
                                    'ticket_replies' => TicketReplyResource::collection($ticket_replies) ,
                                ]);
    }

    /**
     * @OA\Post(
     *     path="/api/ticket-replies/store",
     *     summary="Store new ticket reply",
     *     tags={"Ticket replies"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="ticket_id",
     *                     type="integer",
     *                     example="3"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                     example="Wonderful description!"
     *                 ),
     *                 @OA\Property(
     *                     property="file",
     *                     type="file",
     *                     format="binary"
     *                 ),
     *             )
     *         )
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
    public function store ( Request $request ) {
        $request->validate([
                               'description' => [
                                   'required' ,
                                   'string' ,
                                   'max:1000' ,
                               ] ,
                               'file' => [
                                   'nullable' ,
                                   'file' ,
                                   'max:10000' ,
                               ] ,
                           ]);
        $ticket = Ticket::query()
                        ->where('user_id' , Auth::user()->id)
                        ->where('id' , $request->get('ticket_id'))
                        ->firstOrFail();
        $ticket->ticket_status_id = TicketStatus::PENDING;
        $ticket->save();
        $ticket_reply = $ticket->ticketReplies()
                               ->create([
                                            'description' => $request->get('description') ,
                                            'user_id' => Auth::user()->id ,
                                        ]);
        if ( $request->hasFile('file') ) {
            $ticket_reply->addMediaFromRequest('file')
                         ->toMediaCollection('file');
        }

        return response()->json([
                                    'ticket' => TicketResource::make($ticket) ,
                                    'ticket_replies' => TicketReplyResource::collection($ticket->ticketReplies) ,
                                ]);
    }
}
