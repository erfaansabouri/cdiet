<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlanResource;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller {
    /**
     * @OA\Get(
     *     path="/api/plans/index",
     *     summary="Get list of plans",
     *     tags={"Plans"},
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
        $plans = Plan::all();

        return response()->json([
                                    'plans' => PlanResource::collection($plans),
                                ]);
    }
}
