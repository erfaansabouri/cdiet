<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BannerResource;
use App\Http\Resources\HomeMenuItemResource;
use App\Http\Resources\TextResource;
use App\Models\Text;
use App\Services\HomeService;
use Illuminate\Http\Request;

class HomeController extends Controller {
    /**
     * @OA\Get(
     *     path="/api/home/show",
     *     summary="Home",
     *     tags={"Home"},
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
    public function show () {
        $home_service = ( new HomeService() );
        $banners = BannerResource::collection($home_service->banners());
        $menu = HomeMenuItemResource::collection($home_service->homeMenuItems());

        return response()->json(compact('banners' , 'menu'));
    }

    /**
     * @OA\Get(
     *     path="/api/home/texts",
     *     summary="Home",
     *     tags={"Home"},
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
    public function texts () {
        return TextResource::collection(Text::all());
    }
}
