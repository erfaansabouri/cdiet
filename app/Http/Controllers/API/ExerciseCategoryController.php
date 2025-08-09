<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExerciseCategoryResource;
use App\Models\ExerciseCategory;
use Illuminate\Http\Request;

class ExerciseCategoryController extends Controller {
    /**
     * @OA\Get(
     *     path="/api/exercise-categories/index",
     *     summary="Get list of exercise categories",
     *     tags={"Exercise categories"},
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
        $exercise_categories = ExerciseCategory::query()
                                               ->notPremium()
                                               ->withCount('exercises')
                                               ->get();

        return response()->json([
                                    'exercise_categories' => ExerciseCategoryResource::collection($exercise_categories) ,
                                ]);
    }

    /**
     * @OA\Get(
     *     path="/api/exercise-categories/premium/index",
     *     summary="Get list of premium exercise categories",
     *     tags={"Exercise categories"},
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
    public function premiumIndex ( Request $request ) {
        $exercise_categories = ExerciseCategory::query()
                                               ->premium()
                                               ->withCount('exercises')
                                               ->get();

        return response()->json([
                                    'exercise_categories' => ExerciseCategoryResource::collection($exercise_categories) ,
                                ]);
    }
}
