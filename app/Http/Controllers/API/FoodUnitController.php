<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\FoodUnitResource;
use App\Models\FoodUnit;
use Illuminate\Http\Request;

class FoodUnitController extends Controller {
    /**
     * @OA\Get(
     *     path="/api/food-units/index",
     *     summary="Get list of food units",
     *     operationId="index",
     *     tags={"Food Units"},
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
        $request->validate([
                               'page' => [ 'nullable' ] ,
                           ]);

        $food_units = FoodUnit::query()
                              ->latest()
                              ->simplePaginate(12);

        return response()->json([
                                    'food_units' => FoodUnitResource::collection($food_units->items()),
                                    'current_page' => $food_units->currentPage(),
                                    'next_page_url' => $food_units->nextPageUrl(),
                                    'previous_page_url' => $food_units->previousPageUrl(),
                                    'per_page' => $food_units->perPage(),
                                ]);
    }
}
