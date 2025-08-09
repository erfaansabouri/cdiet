<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use App\Notifications\UserSendTicketNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller {
    /**
     * @OA\Get(
     *      path="/api/tickets/index",
     *      tags={"Tickets"},
     *      summary="Tickets list",
     *
     *     	 @OA\Parameter(
     *         description="ticket_status_id",
     *         in="query",
     *         name="ticket_status_id",
     *         required=false,
     *
     *         @OA\Schema(type="integer"),
     *     ),
     *
     *     	 @OA\Parameter(
     *         description="ticket_category_id",
     *         in="query",
     *         name="ticket_category_id",
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
        $user = Auth::guard('api')
                    ->user();
        $tickets = Ticket::query()
                         ->with([
                                    'ticketStatus' ,
                                    'ticketCategory' ,
                                    'user' ,
                                    'ticketReplies.user' ,
                                    'ticketReplies.admin' ,
                                ])
                         ->where('user_id' , $user->id)
                         ->when($request->ticket_status_id , function ( $query ) use ( $request ) {
                             $query->where('ticket_status_id' , $request->ticket_status_id);
                         })
                         ->when($request->ticket_category_id , function ( $query ) use ( $request ) {
                             $query->where('ticket_category_id' , $request->ticket_category_id);
                         })
                         ->orderByDesc('created_at')
                         ->simplePaginate(10);

        return response()->json([
                                    'tickets' => TicketResource::collection($tickets) ,
                                    'current_page' => $tickets->currentPage() ,
                                    'next_page_url' => $tickets->nextPageUrl() ,
                                    'previous_page_url' => $tickets->previousPageUrl() ,
                                    'per_page' => $tickets->perPage() ,
                                ]);
    }

    /**
     * @OA\Post(
     *     path="/api/tickets/store",
     *     summary="Store new ticket",
     *     tags={"Tickets"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *
     *             @OA\Schema(
     *
     *                 @OA\Property(
     *                     property="ticket_category_id",
     *                     type="string",
     *                     example="1"
     *                 ),
     *                 @OA\Property(
     *                     property="title",
     *                     type="string",
     *                     example="This is my new ticket title"
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
                               'title' => [
                                   'nullable' ,
                                   'string' ,
                                   'max:191' ,
                               ] ,
                               'description' => [
                                   'required' ,
                                   'string' ,
                                   'max:1000' ,
                               ] ,
                               'ticket_category_id' => [
                                   'required' ,
                                   'exists:ticket_categories,id' ,
                               ] ,
                               'file' => [
                                   'nullable' ,
                                   'file' ,
                                   'max:10000' ,
                               ] ,
                           ]);
        $ticket = new Ticket();
        $ticket->user_id = Auth::user()->id;
        $ticket->fill($request->only('title' , 'ticket_category_id'));
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

        Auth::user()->notify(new UserSendTicketNotification());

        return response()->json([ 'ticket' => TicketResource::make($ticket) ]);
    }
}
