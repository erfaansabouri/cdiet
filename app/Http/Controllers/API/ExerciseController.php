<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExerciseResource;
use App\Http\Resources\FoodResource;
use App\Models\Exercise;
use App\Models\Food;
use Illuminate\Http\Request;

class ExerciseController extends Controller {
    /**
     * @OA\Get(
     *     path="/api/exercises/index",
     *     summary="Get list of exercises",
     *     tags={"Exercises"},
     *     	 @OA\Parameter(
     *         description="exercise_category_id",
     *         in="query",
     *         name="exercise_category_id",
     *         required=true,
     *
     *         @OA\Schema(type="integer"),
     *     ),
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
     *
     */
    public function index ( Request $request ) {
        $request->validate([
                               'exercise_category_id' => [
                                   'required' ,
                                   'exists:exercise_categories,id' ,
                               ] ,
                           ]);
        $exercises = Exercise::query()
                             ->withCount([
                                             'likes' ,
                                             'comments' ,
                                         ])
                             ->where('exercise_category_id' , $request->get('exercise_category_id'))
                             ->simplePaginate(12);

        return response()->json([
                                    'exercises' => ExerciseResource::collection($exercises->items()) ,
                                    'current_page' => $exercises->currentPage() ,
                                    'next_page_url' => $exercises->nextPageUrl() ,
                                    'previous_page_url' => $exercises->previousPageUrl() ,
                                    'per_page' => $exercises->perPage() ,
                                ]);
    }

    /**
     * @OA\Get(
     *     path="/api/exercises/all",
     *     summary="Get all of exercises",
     *     tags={"Exercises"},
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

        $exercises = Exercise::all();

        return response()->json([
                                    'exercises' => ExerciseResource::collection($exercises) ,
                                ]);
    }
}
