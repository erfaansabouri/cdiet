<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\FoodResource;
use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends Controller {
    /**
     * @OA\Get(
     *     path="/api/food/index",
     *     summary="Get index of food",
     *     tags={"Food"},
     *     	 @OA\Parameter(
     *         description="search",
     *         in="query",
     *         name="search",
     *         required=true,
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
     *
     */
    public function index ( Request $request ) {
        $food = Food::query()
                    ->when($request->get('search') , function ( $query ) use ( $request ) {
                        $query->where('title' , 'like' , '%' . $request->get('search') . '%');
                    })
                    ->get();

        return response()->json([
                                    'food' => FoodResource::collection($food) ,
                                ]);
    }

    /**
     * @OA\Get(
     *     path="/api/food/all",
     *     summary="Get list of food",
     *     tags={"Food"},
     *     	 @OA\Parameter(
     *         description="food_category_id",
     *         in="query",
     *         name="food_category_id",
     *         required=true,
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
     *
     */
    public function all ( Request $request ) {
        $request->validate([
                               'food_category_id' => [
                                   'required' ,
                                   'exists:food_categories,id' ,
                               ] ,
                           ]);
        $food = Food::query()
                    ->where('food_category_id' , $request->get('food_category_id'))
                    ->get();

        return response()->json([
                                    'food' => FoodResource::collection($food) ,
                                ]);
    }
}
