<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\DietaryCooking;
use Illuminate\Http\Request;

class DietaryCookingCommentController extends Controller {
    /**
     * @OA\Get(
     *     path="/api/dietary-cooking-comments/index",
     *     summary="Get list of dietary cooking comments",
     *     tags={"Dietary cooking comments"},
     *     	 @OA\Parameter(
     *         description="dietary_cooking_id",
     *         in="query",
     *         name="dietary_cooking_id",
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
                               'dietary_cooking_id' => [
                                   'required' ,
                                   'exists:dietary_cookings,id' ,
                               ] ,
                               'page' => [ 'nullable' ] ,
                           ]);
        $dietary_cooking = DietaryCooking::query()
                                         ->findOrFail($request->get('dietary_cooking_id'));
        $dietary_cooking_comments = $dietary_cooking->comments()
                                                    ->verified()
                                                    ->latest()
                                                    ->simplePaginate(12);

        return response()->json([
                                    'dietary_cooking_comments' => CommentResource::collection($dietary_cooking_comments->items()) ,
                                    'current_page' => $dietary_cooking_comments->currentPage() ,
                                    'next_page_url' => $dietary_cooking_comments->nextPageUrl() ,
                                    'previous_page_url' => $dietary_cooking_comments->previousPageUrl() ,
                                    'per_page' => $dietary_cooking_comments->perPage() ,
                                ]);
    }

    /**
     * @OA\Post(
     *     path="/api/dietary-cooking-comments/store",
     *     summary="Store new dietary_cooking comment",
     *     tags={"Dietary cooking comments"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\MediaType(
     *             mediaType="application/json",
     *
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="dietary_cooking_id",
     *                     type="integer",
     *                     example="1",
     *                     description=""
     *                 ),
     *                 @OA\Property(
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
                               'dietary_cooking_id' => [
                                   'required' ,
                                   'exists:dietary_cookings,id' ,
                               ] ,
                               'parent_id' => [
                                   'nullable' ,
                               ] ,
                               'text' => [
                                   'required' ,
                                   'max:1000' ,
                               ] ,
                           ]);
        $dietary_cooking = DietaryCooking::query()
                                         ->findOrFail($request->get('dietary_cooking_id'));
        $dietary_cooking->addComment($request->get('text'), $request->get('parent_id'));

        return response()->json([
                                    'status' => true ,
                                    'message' => 'نظر شما با موفقیت ارسال شد و پس از تایید نمایش داده میشود' ,
                                ]);
    }
}
