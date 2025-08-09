<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TermResource;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TermController extends Controller {
    /**
     * @OA\Get(
     *     path="/api/terms/show",
     *     summary="Get term text",
     *     operationId="show",
     *     tags={"Terms"},
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
    public function show ( Request $request ) {

        $term = Term::query()
                    ->first();

        return response()->json([
                                    'term' => TermResource::make($term) ,
                                ]);
    }

    /**
     * @OA\Put(
     *     path="/api/terms/accept",
     *     summary="Accept terms",
     *     operationId="accept",
     *     tags={"Terms"},
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
    public function accept ( Request $request ) {

        $user = Auth::user();
        $user->terms_accepted_at = now();
        $user->save();

        return response()->json([
                                    'status' => true ,
                                    'message' => 'قوانین با موفقیت پذیرفته شد.' ,
                                ]);
    }
}
