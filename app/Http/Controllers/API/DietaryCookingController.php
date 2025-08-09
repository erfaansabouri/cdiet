<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\DietaryCookingResource;
use App\Models\DietaryCooking;
use Illuminate\Http\Request;

class DietaryCookingController extends Controller {
    /**
     * @OA\Get(
     *     path="/api/dietary-cookings/index",
     *     summary="Get list of dietary cookings",
     *     tags={"Dietary cookings"},
     *     	 @OA\Parameter(
     *         description="dietary_cooking_category_id",
     *         in="query",
     *         name="dietary_cooking_category_id",
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
                               'dietary_cooking_category_id' => [
                                   'required' ,
                                   'exists:dietary_cooking_categories,id' ,
                               ] ,
                           ]);
        $dietary_cookings = DietaryCooking::query()
                                          ->withCount([
                                                          'likes' ,
                                                          'comments',
                                                      ])
                                          ->where('dietary_cooking_category_id' , $request->get('dietary_cooking_category_id'))
                                          ->simplePaginate(12);

        return response()->json([
                                    'dietary_cookings' => DietaryCookingResource::collection($dietary_cookings->items()) ,
                                    'current_page' => $dietary_cookings->currentPage() ,
                                    'next_page_url' => $dietary_cookings->nextPageUrl() ,
                                    'previous_page_url' => $dietary_cookings->previousPageUrl() ,
                                    'per_page' => $dietary_cookings->perPage() ,
                                ]);
    }
}
