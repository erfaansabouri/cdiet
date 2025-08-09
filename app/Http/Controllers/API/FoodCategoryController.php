<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\FoodCategoryResource;
use App\Models\FoodCategory;
use Illuminate\Http\Request;

class FoodCategoryController extends Controller {
    /**
     * @OA\Get(
     *     path="/api/food-categories/index",
     *     summary="Get list of food categories",
     *     tags={"Food categories"},
     *     	 @OA\Parameter(
     *         description="search",
     *         in="query",
     *         name="search",
     *         required=false,
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
    public function index ( Request $request ) {
        $food_categories = FoodCategory::query()
                                       ->when($request->get('search') , function ( $query ) use ( $request ) {
                                           $query->where('title' , 'like' , '%' . $request->get('search') . '%');
                                       })
                                       ->get();

        return response()->json([
                                    'food_categories' => FoodCategoryResource::collection($food_categories) ,
                                ]);
    }
}
