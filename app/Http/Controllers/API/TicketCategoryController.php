<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TicketCategoryResource;
use App\Models\TicketCategory;
use Illuminate\Http\Request;

class TicketCategoryController extends Controller {
    /**
     * @OA\Get(
     *     path="/api/ticket-categories/index",
     *     summary="Get list of ticket categories",
     *     tags={"Ticket categories"},
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
        $ticket_categories = TicketCategory::all();
        $ticket_categories = TicketCategoryResource::collection($ticket_categories);

        return response()->json([
                                    'ticket_categories' => $ticket_categories ,
                                ]);
    }
}
