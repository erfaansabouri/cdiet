<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BannerResource;
use App\Models\Banner;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BannerController extends Controller {
    /**
     * @OA\Get(
     *     path="/api/banners/index",
     *     summary="Banners",
     *     tags={"Banners"},
     *          	 @OA\Parameter(
     *          description="location",
     *          in="query",
     *          name="location",
     *          required=true,
     *
     *          @OA\Schema(type="string"),
     *      ),
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
                               'location' => [ 'nullable' ] ,
                           ]);
        $banners = Banner::query()
                         ->when($request->get('location') , function ( Builder $query ) {
                             $query->where('location' , request('location'))
            })
                         ->get();
        $banners = BannerResource::collection($banners);

        return response()->json(compact('banners'));
    }
}
