<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\DietaryCookingCategoryResource;
use App\Models\DietaryCookingCategory;
use Illuminate\Http\Request;

class DietaryCookingCategoryController extends Controller {
    /**
     * @OA\Get(
     *     path="/api/dietary-cooking-categories/index",
     *     summary="Get list of dietary cooking categories",
     *     tags={"Dietary cooking categories"},
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
        $dietary_cooking_categories = DietaryCookingCategory::query()
                                               ->withCount('dietaryCookings')
                                               ->get();

        return response()->json([
                                    'dietary_cooking_categories' => DietaryCookingCategoryResource::collection($dietary_cooking_categories) ,
                                ]);
    }
}
