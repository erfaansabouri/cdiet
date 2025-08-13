<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\MealTimeResource;
use App\Models\Mealtime;
use App\Models\User;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MealtimeController extends Controller {
    /**
     * @OA\Get(
     *     path="/api/mealtimes/index",
     *     summary="Get list of mealtimes",
     *     tags={"Mealtimes"},
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
        $mealtimes = [];
        $breakfast = $this->randomMealtime('صبحانه');
        $lunch = $this->randomMealtime('ناهار');
        $between = $this->randomMealtime('میان وعده');
        $dinner = $this->randomMealtime('شام');
        if ( $breakfast ) {
            $mealtimes[] = $breakfast;
        }
        if ( $lunch ) {
            $mealtimes[] = $lunch;
        }
        if ( $between ) {
            $mealtimes[] = $between;
        }
        if ( $dinner ) {
            $mealtimes[] = $dinner;
        }

        return response()->json([
                                    'mealtimes' => MealtimeResource::collection($mealtimes) ,
                                ]);
    }

    private function randomMealtime ($type) {
        $user = auth('api')->user();
        $weekSeed = floor(Carbon::now()->timestamp / ( 60 * 60 * 24 * 7 ));
        // Each 7 days => new integer
        return Mealtime::query()
                            ->with([ 'mealtimeWeekdays' ])
                            ->where('title' , 'like' , "%$type%")
                            ->when($user->pregnant_status , function ( Builder $query ) {
                                $query->where('for_pregnant' , true);
                            })
                            ->when($user->lactation_status , function ( Builder $query ) {
                                $query->where('for_lactation' , true);
                            })
                            ->where('group' , $user->goal)
                            ->when($user->goal == User::GOALS[ 'gain-weight' ] , function ( Builder $query ) use ( $user ) {
                                $query->where('from' , '<=' , $user->target_weight - $user->weight)
                                      ->where('to' , '>=' , $user->target_weight - $user->weight);
                            })
                            ->when($user->goal == User::GOALS[ 'loose-weight' ] , function ( Builder $query ) use ( $user ) {
                                $query->where('from2' , '<=' , $user->weight - $user->target_weight)
                                      ->where('to2' , '>=' , $user->weight - $user->target_weight);
                            })
                            ->inRandomOrder($weekSeed)
                            ->first();
    }
}
