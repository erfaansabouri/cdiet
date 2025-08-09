<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use App\Models\ExerciseLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExerciseLikeController extends Controller {
    /**
     * @OA\Put(
     *     path="/api/exercise-likes/like/{exercise_id}",
     *     summary="Like an exercise",
     *     tags={"Exercise Likes"},
     *     	 @OA\Parameter(
     *         description="exercise_id",
     *         in="path",
     *         name="exercise_id",
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
     */
    public function like ( Request $request , $exercise_id ) {
        $exercise = Exercise::query()
                            ->findOrFail($exercise_id);
        $exercise->like();

        return response()->json([
                                    'status' => true ,
                                    'message' => 'با موفقیت لایک شد.' ,
                                ]);
    }

    /**
     * @OA\Put(
     *     path="/api/exercise-likes/unlike/{exercise_id}",
     *     summary="Unlike an exercise",
     *     tags={"Exercise Likes"},
     *     	 @OA\Parameter(
     *         description="exercise_id",
     *         in="path",
     *         name="exercise_id",
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
     */
    public function unlike ( Request $request , $exercise_id ) {

        $exercise = Exercise::query()
                            ->findOrFail($exercise_id);
        $exercise->unlike();

        return response()->json([
                                    'status' => true ,
                                    'message' => 'با موفقیت آنلایک شد.' ,
                                ]);
    }
}
