<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleCommentController extends Controller {
    /**
     * @OA\Get(
     *     path="/api/article-comments/index",
     *     summary="Get list of article comments",
     *     tags={"Article comments"},
     *     	 @OA\Parameter(
     *         description="article_id",
     *         in="query",
     *         name="article_id",
     *         required=false,
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
     */
    public function index ( Request $request ) {
        $request->validate([
                               'article_id' => [
                                   'required' ,
                                   'exists:articles,id' ,
                               ] ,
                           ]);
        $article = Article::query()
                          ->findOrFail($request->get('article_id'));
        $article_comments = $article->comments()
                                    ->verified()
                                    ->latest()
                                    ->simplePaginate(12);

        return response()->json([
                                    'article_comments' => CommentResource::collection($article_comments->items()) ,
                                    'current_page' => $article_comments->currentPage() ,
                                    'next_page_url' => $article_comments->nextPageUrl() ,
                                    'previous_page_url' => $article_comments->previousPageUrl() ,
                                    'per_page' => $article_comments->perPage() ,
                                ]);
    }

    /**
     * @OA\Post(
     *     path="/api/article-comments/store",
     *     summary="Store new article comment",
     *     tags={"Article comments"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\MediaType(
     *             mediaType="application/json",
     *
     *             @OA\Schema(
     *
     *                 @OA\Property(
     *                     property="article_id",
     *                     type="integer",
     *                     example="1",
     *                     description=""
     *                 ),
     *                      @OA\Property(
     *                      property="parent_id",
     *                      type="integer",
     *                      example="1",
     *                      description=""
     *                  ),
     *                 @OA\Property(
     *                     property="text",
     *                     type="string",
     *                     example="My note body",
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
                               'article_id' => [
                                   'required' ,
                                   'exists:articles,id' ,
                               ] ,
                               'parent_id' => [
                                   'nullable' ,
                               ] ,
                               'text' => [
                                   'required' ,
                                   'string' ,
                                   'max:500' ,
                               ] ,
                           ]);
        $article = Article::query()
                          ->findOrFail($request->get('article_id'));
        $article->addComment($request->get('text'), $request->get('parent_id'));

        return response()->json([
                                    'status' => true ,
                                    'message' => 'نظر شما با موفقیت ارسال شد و پس از تایید نمایش داده میشود' ,
                                ]);
    }
}
