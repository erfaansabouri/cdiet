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

    private function randomMealtime ( $type ) {
        $user = auth('api')->user();
        $weekSeed = floor(Carbon::now()->timestamp / ( 60 * 60 * 24 * 7 ));
        // Each 7 days => new integer
        $mealtimes = Mealtime::query()
                             ->with([ 'mealtimeWeekdays' ])
                             ->where('title' , 'like' , "%$type%")
                             ->when($user->pregnant_status , function ( Builder $query ) {
                                 $query->where('for_pregnant' , true);
                             })
                             ->when($user->lactation_status , function ( Builder $query ) {
                                 $query->where('for_lactation' , true);
                             })
                             ->when(!$user->pregnant_status && !$user->lactation_status && $user->goal == User::GOALS[ 'maintain-weight' ] , function ( Builder $query ) {
                                 $query->where('group' , User::GOALS[ 'maintain-weight' ]);
                             });
        if ( !$user->pregnant_status && !$user->lactation_status && $user->goal != User::GOALS[ 'maintain-weight' ] ) {
            $mealtimes = $mealtimes->when($user->targetWeight() > $user->weight , function ( Builder $query ) use ( $user ) {
                $query->where('from2' , '<=' , abs($user->targetWeight() - $user->weight))
                      ->where('to2' , '>=' , abs($user->targetWeight() - $user->weight));
            })
                                   ->when($user->weight > $user->targetWeight() , function ( Builder $query ) use ( $user ) {
                                       $query->where('from' , '<=' , abs($user->weight - $user->targetWeight()))
                                             ->where('to' , '>=' , abs($user->weight - $user->targetWeight()));
                                   });
        }

        return $mealtimes->inRandomOrder($weekSeed)
                         ->first();
    }
}
