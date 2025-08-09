<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\WeightChangeLog;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Verta;

class WeightChangeLogController extends Controller {
    /**
     * @OA\Get(
     *      path="/api/weight-change-logs/chart",
     *      tags={"Weight change logs"},
     *      summary="Chart of weight change logs",
     *
     *     	 @OA\Parameter(
     *         description="date",
     *         in="query",
     *         name="date",
     *         required=false,
     *
     *         @OA\Schema(type="string"),
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
    public function chart ( Request $request ) {
        $request->validate([
                               'date' => [
                                   'required' ,
                                   'jdate' ,
                               ] ,
                           ]);
        $started_at = Verta::parse($request->get('date'))->startMonth();
        $ended_at = Verta::parse($request->get('date'))->endMonth();
        $gregorian_started_at =  Verta::jalaliToGregorian($started_at->year , $started_at->month , $started_at->day);
        $gregorian_ended_at =  Verta::jalaliToGregorian($ended_at->year , $ended_at->month , $ended_at->day);
        $weight_change_logs = WeightChangeLog::where('user_id' , Auth::user()->id)
                                             ->whereBetween('created_at' , [
                                                 Carbon::createFromDate($gregorian_started_at[ 0 ] , $gregorian_started_at[ 1 ] , $gregorian_started_at[ 2 ]) ,
                                                 Carbon::createFromDate($gregorian_ended_at[ 0 ] , $gregorian_ended_at[ 1 ] , $gregorian_ended_at[ 2 ]) ,
                                             ])
                                             ->orderBy('created_at')
                                             ->get();
        $chart = [];
        foreach ( $weight_change_logs as $key => $weight_change_log ) {
            $chart[] = [
                'x' => 'وزن ' . $key + 1 ,
                'y' => $weight_change_log->weight ,
            ];
        }

        return response()->json([
                                    'chart' => $chart,
                                ]);
    }
}
