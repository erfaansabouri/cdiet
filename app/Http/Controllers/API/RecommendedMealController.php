<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\RecommendedMealResource;
use App\Models\RecommendedMeal;
use Auth;
use Illuminate\Http\Request;

class RecommendedMealController extends Controller {
    /**
     * @OA\Get(
     *     path="/api/recommended-meals/index",
     *     summary="Get list of recommended meals",
     *     tags={"Recommended meals"},
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
        $user = Auth::user();
        $recommended_meals = RecommendedMeal::query()
                                            ->where('goal' , $user->goal)
                                            ->get();
        foreach ( $recommended_meals as $recommended_meal ) {
            $today_meals = $user->userActivities()
                                ->with([ 'food' ])
                                ->where('recommended_meal_id' , $recommended_meal->id)
                                ->today()
                                ->get();
            if ( count($today_meals) ) {
                $new_description = $today_meals->pluck('food.title')
                                               ->implode('، ');
                $recommended_meal->description = $new_description;
            }
        }

        return response()->json([
                                    'recommended_meals' => RecommendedMealResource::collection($recommended_meals) ,
                                ]);
    }
}
