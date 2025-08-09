<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\DietResource;
use App\Models\Diet;
use Illuminate\Http\Request;

class DietController extends Controller {
    /**
     * @OA\Get(
     *     path="/api/diets/index",
     *     summary="Get list of diets",
     *     tags={"Diets"},
     *     	 @OA\Parameter(
     *         description="diet_category_id",
     *         in="query",
     *         name="diet_category_id",
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
                               'diet_category_id' => [
                                   'required' ,
                                   'exists:diet_categories,id' ,
                               ] ,
                           ]);
        $diets = Diet::query()
                     ->where('diet_category_id' , $request->get('diet_category_id'))
                     ->simplePaginate(12);

        return response()->json([
                                    'diets' => DietResource::collection($diets->items()) ,
                                    'current_page' => $diets->currentPage() ,
                                    'next_page_url' => $diets->nextPageUrl() ,
                                    'previous_page_url' => $diets->previousPageUrl() ,
                                    'per_page' => $diets->perPage() ,
                                ]);
    }
}
