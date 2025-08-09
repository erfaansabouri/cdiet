<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller {
    /**
     * @OA\Get(
     *     path="/api/articles/index",
     *     summary="Get list of articles",
     *     tags={"Articles"},
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
                               'page' => [ 'nullable' ] ,
                           ]);
        $articles = Article::query()
                           ->latest()
                           ->simplePaginate(12);

        return response()->json([
                                    'articles' => ArticleResource::collection($articles->items()) ,
                                    'current_page' => $articles->currentPage() ,
                                    'next_page_url' => $articles->nextPageUrl() ,
                                    'previous_page_url' => $articles->previousPageUrl() ,
                                    'per_page' => $articles->perPage() ,
                                ]);
    }

    /**
     * @OA\Get(
     *     path="/api/articles/show/{id}",
     *     summary="Show single article",
     *     tags={"Articles"},
     *     	 @OA\Parameter(
     *         description="id",
     *         in="path",
     *         name="id",
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
    public function show ( Request $request , $id ) {
        $article = Article::query()
                          ->findOrFail($id);

        return response()->json([
                                    'article' => ArticleResource::make($article) ,
                                ]);
    }
}
