<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\MealTimeResource;
use App\Models\Mealtime;
use Auth;
use Illuminate\Http\Request;

class MealtimeController extends Controller {
    /**
     * @OA\Get(
     *     path="/api/mealtimes/index",
     *     summary="Get list of mealtimes",
     *     tags={"Mealtimes"},
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
        $mealtimes = Mealtime::query()
                             ->with([ 'mealtimeWeekdays' ])
                             ->get();

        return response()->json([
                                    'mealtimes' => MealtimeResource::collection($mealtimes) ,
                                ]);
    }
}
