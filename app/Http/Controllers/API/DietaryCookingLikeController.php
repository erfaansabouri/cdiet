<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DietaryCooking;
use Illuminate\Http\Request;

class DietaryCookingLikeController extends Controller {
    /**
     * @OA\Put(
     *     path="/api/dietary-cooking-likes/like/{dietary_cooking_id}",
     *     summary="Like a dietary cooking",
     *     tags={"Dietary cooking Likes"},
     *     	 @OA\Parameter(
     *         description="dietary_cooking_id",
     *         in="path",
     *         name="dietary_cooking_id",
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
    public function like ( Request $request , $dietary_cooking_id ) {
        $dietary_cooking = DietaryCooking::query()
                            ->findOrFail($dietary_cooking_id);
        $dietary_cooking->like();

        return util()->simpleSuccess('با موفقیت لایک شد.');
    }

    /**
     * @OA\Put(
     *     path="/api/dietary-cooking-likes/unlike/{dietary_cooking_id}",
     *     summary="Unike a dietary cooking",
     *     tags={"Dietary cooking Likes"},
     *     	 @OA\Parameter(
     *         description="dietary_cooking_id",
     *         in="path",
     *         name="dietary_cooking_id",
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
    public function unlike ( Request $request , $dietary_cooking_id ) {

        $dietary_cooking = DietaryCooking::query()
                                         ->findOrFail($dietary_cooking_id);
        $dietary_cooking->unlike();

        return util()->simpleSuccess('با موفقیت آنلایک شد.');
    }
}
