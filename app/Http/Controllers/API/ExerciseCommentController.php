<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Http\Resources\ExerciseCommentResource;
use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseCommentController extends Controller {
    /**
     * @OA\Get(
     *     path="/api/exercise-comments/index",
     *     summary="Get list of exercise comments",
     *     tags={"Exercise comments"},
     *     	 @OA\Parameter(
     *         description="exercise_id",
     *         in="query",
     *         name="exercise_id",
     *         required=true,
     *         example="1",
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
                               'exercise_id' => [
                                   'required' ,
                                   'exists:exercises,id' ,
                               ] ,
                               'page' => [ 'nullable' ] ,
                           ]);
        $exercise = Exercise::query()
                            ->findOrFail($request->get('exercise_id'));
        $exercise_comments = $exercise->comments()
                                      ->verified()
                                      ->latest()
                                      ->simplePaginate(12);

        return response()->json([
                                    'exercise_comments' => CommentResource::collection($exercise_comments->items()) ,
                                    'current_page' => $exercise_comments->currentPage() ,
                                    'next_page_url' => $exercise_comments->nextPageUrl() ,
                                    'previous_page_url' => $exercise_comments->previousPageUrl() ,
                                    'per_page' => $exercise_comments->perPage() ,
                                ]);
    }

    /**
     * @OA\Post(
     *     path="/api/exercise-comments/store",
     *     summary="Store new exercise comment",
     *     tags={"Exercise comments"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\MediaType(
     *             mediaType="application/json",
     *
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="exercise_id",
     *                     type="integer",
     *                     example="1",
     *                     description=""
     *                 ),
     *                           @OA\Property(
     *                       property="parent_id",
     *                       type="integer",
     *                       example="1",
     *                       description=""
     *                   ),
     *                 @OA\Property(
     *                     property="text",
     *                     type="string",
     *                     example="Simple text",
     *                     description=""
     *                 ),
     *             )
     *         )
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
    public function store ( Request $request ) {
        $request->validate([
                               'exercise_id' => [
                                   'required' ,
                                   'exists:exercises,id' ,
                               ] ,
                               'parent_id' => [
                                   'nullable' ,
                               ] ,
                               'text' => [
                                   'required' ,
                                   'max:1000' ,
                               ] ,
                           ]);
        $exercise = Exercise::query()
                            ->findOrFail($request->get('exercise_id'));
        $exercise->addComment($request->get('text'), $request->get('parent_id'));

        return response()->json([
                                    'status' => true ,
                                    'message' => 'نظر شما با موفقیت ارسال شد و پس از تایید نمایش داده میشود.' ,
                                ]);
    }
}
