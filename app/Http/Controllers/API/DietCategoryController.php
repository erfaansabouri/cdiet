<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\DietCategoryResource;
use App\Models\DietCategory;
use Illuminate\Http\Request;

class DietCategoryController extends Controller {
    /**
     * @OA\Get(
     *     path="/api/diet-categories/index",
     *     summary="Get list of diet categories",
     *     tags={"Diet categories"},
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
        $diet_categories = DietCategory::query()
                                       ->withCount('diets')
                                       ->get();

        return response()->json([
                                    'diet_categories' => DietCategoryResource::collection($diet_categories) ,
                                ]);
    }
}
