<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CustomBurnedCalorie;
use App\Models\CustomGainedCalorie;
use App\Models\Exercise;
use App\Models\Food;
use App\Models\MealtimeWeekday;
use App\Models\UserActivity;
use Auth;
use Illuminate\Http\Request;

class UserActivityController extends Controller {
    /**
     * @OA\Post(
     *     path="/api/user-activities/add-food",
     *     summary="Add food",
     *     tags={"User activities"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="date", type="string", format="date", description="The
     *                                           date for adding food items (jdate format).",
     *                                           example="1402/07/15"),
     *             @OA\Property(property="food_ids", type="array", @OA\Items(type="integer"),
     *                                               description="An array of food item IDs to
     *                                               add."),
     *             @OA\Property(property="recommended_meal_id", type="integer", format="integer",
     *                                                          description="Its optional",
     *                                                          example="1"),
     *         ),
     *     ),
     * @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     * @OA\Response(response=204, description="Successful"),
     * @OA\Response(response=400, description="Bad request"),
     * @OA\Response(response=404, description="Not Found"),
     * @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     * @OA\Response(response=422, description="Unprocessable Content", @OA\JsonContent()),
     *     security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     *
     */
    public function addFood ( Request $request ) {
        $request->validate([
                               'date' => [
                                   'required' ,
                                   'jdate' ,
                               ] ,
                               'food_ids' => [ 'array' ] ,
                               'recommended_meal_id' => [
                                   'nullable' ,
                                   'exists:recommended_meals,id' ,
                               ] ,
                           ]);
        $food_ids = Food::query()
                        ->whereIn('id' , $request->get('food_ids'))
                        ->get()
                        ->pluck('id')
                        ->toArray();
        foreach ( $food_ids as $food_id ) {
            UserActivity::query()
                        ->create([
                                     'user_id' => Auth::user()->id ,
                                     'date' => $request->get('date') ,
                                     'type' => UserActivity::TYPES[ 'food' ] ,
                                     'food_id' => $food_id ,
                                     'recommended_meal_id' => $request->get('recommended_meal_id') ,
                                 ]);
        }

        return util()->simpleSuccess('وعده های غذایی با موفقیت افزوده شدند!');
    }

    /**
     * @OA\Post(
     *     path="/api/user-activities/add-calorie",
     *     summary="Add calorie",
     *     tags={"User activities"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="amount", type="integer", format="integer",
     *                                                          description="Its required",
     *                                                          example="10"),
     *         ),
     *     ),
     * @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     * @OA\Response(response=204, description="Successful"),
     * @OA\Response(response=400, description="Bad request"),
     * @OA\Response(response=404, description="Not Found"),
     * @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     * @OA\Response(response=422, description="Unprocessable Content", @OA\JsonContent()),
     *     security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     *
     */
    public function addCalorie ( Request $request ) {
        $request->validate([
                               'amount' => [
                                   'required' ,
                                   'numeric' ,
                               ] ,
                               'date' => [
                                   'nullable' ,
                                   'jdate' ,
                               ] ,
                           ]);
        CustomGainedCalorie::query()
                           ->create([
                                        'user_id' => Auth::user()->id ,
                                        'date' => $request->get('date') ?? verta()->format('Y/m/d') ,
                                        'amount' => $request->get('amount') ,
                                    ]);

        return util()->simpleSuccess('کالری با موفقیت افزوده شد!');
    }

    /**
     * @OA\Post(
     *     path="/api/user-activities/burn-calorie",
     *     summary="Burn calorie",
     *     tags={"User activities"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="amount", type="integer", format="integer",
     *                                                          description="Its required",
     *                                                          example="10"),
     *         ),
     *     ),
     * @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     * @OA\Response(response=204, description="Successful"),
     * @OA\Response(response=400, description="Bad request"),
     * @OA\Response(response=404, description="Not Found"),
     * @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     * @OA\Response(response=422, description="Unprocessable Content", @OA\JsonContent()),
     *     security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     *
     */
    public function burnCalorie ( Request $request ) {
        $request->validate([
                               'amount' => [
                                   'required' ,
                                   'numeric' ,
                               ] ,
                               'date' => [
                                   'nullable' ,
                                   'jdate' ,
                               ] ,
                           ]);
        CustomBurnedCalorie::query()
                           ->create([
                                        'user_id' => Auth::user()->id ,
                                        'date' => $request->get('date') ?? verta()->format('Y/m/d') ,
                                        'amount' => $request->get('amount') ,
                                    ]);

        return util()->simpleSuccess('کالری با موفقیت کاسته شد!');
    }

    /**
     * @OA\Post(
     *     path="/api/user-activities/add-calorie-by-mealtime-weekday",
     *     summary="add-calorie-by-mealtime-weekday",
     *     tags={"User activities"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="mealtime_weekday_id", type="integer", format="integer",
     *                                                          description="Its required",
     *                                                          example="10"),
     *         ),
     *     ),
     * @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     * @OA\Response(response=204, description="Successful"),
     * @OA\Response(response=400, description="Bad request"),
     * @OA\Response(response=404, description="Not Found"),
     * @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     * @OA\Response(response=422, description="Unprocessable Content", @OA\JsonContent()),
     *     security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     *
     */
    public function addCalorieByMealtimeWeekday ( Request $request ) {
        $request->validate([
                               'mealtime_weekday_id' => [
                                   'required' ,
                               ] ,
                           ]);
        $mealtime_weekday = MealtimeWeekday::query()
                                           ->findOrFail($request->get('mealtime_weekday_id'));
        CustomGainedCalorie::query()
                           ->create([
                                        'user_id' => Auth::user()->id ,
                                        'date' => verta()->format('Y/m/d') ,
                                        'amount' => (int)$mealtime_weekday->calorie ,
                                        'carbohydrate' => (int)$mealtime_weekday->carbohydrate ,
                                        'fat' => (int)$mealtime_weekday->fat ,
                                        'protein' => (int)$mealtime_weekday->protein ,
                                    ]);

        return util()->simpleSuccess('کالری با موفقیت افزوده شد!');
    }

    /**
     * @OA\Post(
     *     path="/api/user-activities/add-exercise",
     *     summary="Add exercise",
     *     tags={"User activities"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="date", type="string", format="date", description="The
     *                                           date for adding food items (jdate format).",
     *                                           example="1402/07/15"),
     *             @OA\Property(property="exercise_ids", type="array", @OA\Items(type="integer"),
     *                                               description="An array of exercise item IDs to
     *                                               add."),
     *         ),
     *     ),
     * @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     * @OA\Response(response=204, description="Successful"),
     * @OA\Response(response=400, description="Bad request"),
     * @OA\Response(response=404, description="Not Found"),
     * @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     * @OA\Response(response=422, description="Unprocessable Content", @OA\JsonContent()),
     *     security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     *
     */
    public function addExercise ( Request $request ) {
        $request->validate([
                               'date' => [
                                   'required' ,
                                   'jdate' ,
                               ] ,
                               'exercise_ids' => [ 'array' ] ,
                           ]);
        $exercise_ids = Exercise::query()
                                ->whereIn('id' , $request->get('exercise_ids'))
                                ->get()
                                ->pluck('id')
                                ->toArray();
        foreach ( $exercise_ids as $exercise_id ) {
            UserActivity::query()
                        ->create([
                                     'user_id' => Auth::user()->id ,
                                     'date' => $request->get('date') ,
                                     'type' => UserActivity::TYPES[ 'exercise' ] ,
                                     'exercise_id' => $exercise_id ,
                                 ]);
        }

        return util()->simpleSuccess('فعالیت ها با موفقیت افزوده شدند!');
    }

    /**
     * @OA\Post(
     *     path="/api/user-activities/did-an-exercise-set",
     *     summary="did-an-exercise-set",
     *     tags={"User activities"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="exercise_id", type="integer", format="integer",
     *                                                          description="Its required",
     *                                                          example="10"),
     *         ),
     *     ),
     * @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     * @OA\Response(response=204, description="Successful"),
     * @OA\Response(response=400, description="Bad request"),
     * @OA\Response(response=404, description="Not Found"),
     * @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     * @OA\Response(response=422, description="Unprocessable Content", @OA\JsonContent()),
     *     security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     *
     */
    public function didAnExerciseSet ( Request $request ) {
        $request->validate([
                               'exercise_id' => [ 'required' ] ,
                           ]);
        $exercise = Exercise::query()
                            ->where('id' , $request->get('exercise_id'))
                            ->firstOrFail();
        UserActivity::query()
                    ->create([
                                 'user_id' => Auth::user()->id ,
                                 'date' => verta()->format('Y/m/d') ,
                                 'type' => UserActivity::TYPES[ 'exercise' ] ,
                                 'exercise_id' => $exercise->id ,
                             ]);

        return util()->simpleSuccess('فعالیت با موفقیت افزوده شد!');
    }

    /**
     * @OA\Put(
     *     path="/api/user-activities/increase-drink-water",
     *     summary="User activity statistic increase drink water",
     *     tags={"User activities"},
     *     	 @OA\Parameter(
     *         description="date",
     *         in="query",
     *         name="date",
     *         required=true,
     *         example="1402/07/15",
     *         @OA\Schema(type="string"),
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
     *
     */
    public function increaseDrinkWater ( Request $request ) {
        $request->validate([
                               'date' => [
                                   'required' ,
                                   'jdate' ,
                               ] ,
                           ]);
        $user = Auth::user();
        $date = $request->get('date');
        $drink_water = UserActivity::query()
                                   ->firstOrCreate([
                                                       'date' => $date ,
                                                       'user_id' => $user->id ,
                                                       'type' => UserActivity::TYPES[ 'drink-water' ] ,
                                                   ]);
        if ( $drink_water->count > 0 ) {
            $drink_water->count = $drink_water->count + 1;
        }
        else {
            $drink_water->count = 1;
        }
        $drink_water->save();

        return response()->json($user->statistic($date));
    }

    /**
     * @OA\Put(
     *     path="/api/user-activities/decrease-drink-water",
     *     summary="User activity statistic decrease drink water",
     *     tags={"User activities"},
     *     	 @OA\Parameter(
     *         description="date",
     *         in="query",
     *         name="date",
     *         required=true,
     *         example="1402/07/15",
     *         @OA\Schema(type="string"),
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
     *
     */
    public function decreaseDrinkWater ( Request $request ) {
        $request->validate([
                               'date' => [
                                   'required' ,
                                   'jdate' ,
                               ] ,
                           ]);
        $user = Auth::user();
        $date = $request->get('date');
        $drink_water = UserActivity::query()
                                   ->firstOrCreate([
                                                       'date' => $date ,
                                                       'user_id' => $user->id ,
                                                       'type' => UserActivity::TYPES[ 'drink-water' ] ,
                                                   ]);
        if ( $drink_water->count > 0 ) {
            $drink_water->count = $drink_water->count - 1;
        }
        else {
            $drink_water->count = 0;
        }
        $drink_water->save();

        return response()->json($user->statistic($date));
    }

    /**
     * @OA\Put(
     *     path="/api/user-activities/manual-step",
     *     summary="User activity statistic manual step",
     *     tags={"User activities"},
     *     	 @OA\Parameter(
     *         description="date",
     *         in="query",
     *         name="date",
     *         required=true,
     *         example="1402/07/15",
     *         @OA\Schema(type="string"),
     *     ),
     *     	 @OA\Parameter(
     *         description="step",
     *         in="query",
     *         name="step",
     *         required=true,
     *         example="100",
     *         @OA\Schema(type="string"),
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
     *
     */
    public function manualStep ( Request $request ) {
        $request->validate([
                               'date' => [
                                   'required' ,
                                   'jdate' ,
                               ] ,
                               'step' => [
                                   'required' ,
                                   'integer' ,
                               ] ,
                           ]);
        $user = Auth::user();
        $date = $request->get('date');
        $step = UserActivity::query()
                            ->firstOrCreate([
                                                'date' => $date ,
                                                'user_id' => $user->id ,
                                                'type' => UserActivity::TYPES[ 'step' ] ,
                                            ]);
        $step->count = (int)$step->count + $request->get('step');
        $step->save();

        return response()->json($user->statistic($date));
    }

    /**
     * @OA\Put(
     *     path="/api/user-activities/increase-step",
     *     summary="User activity statistic increase step",
     *     tags={"User activities"},
     *     	 @OA\Parameter(
     *         description="date",
     *         in="query",
     *         name="date",
     *         required=true,
     *         example="1402/07/15",
     *         @OA\Schema(type="string"),
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
     *
     */
    public function increaseStep ( Request $request ) {
        $request->validate([
                               'date' => [
                                   'required' ,
                                   'jdate' ,
                               ] ,
                           ]);
        $user = Auth::user();
        $date = $request->get('date');
        $step = UserActivity::query()
                            ->firstOrCreate([
                                                'date' => $date ,
                                                'user_id' => $user->id ,
                                                'type' => UserActivity::TYPES[ 'step' ] ,
                                            ]);
        if ( $step->count > 0 ) {
            $step->count = $step->count + 1;
        }
        else {
            $step->count = 1;
        }
        $step->save();

        return response()->json($user->statistic($date));
    }

    /**
     * @OA\Put(
     *     path="/api/user-activities/decrease-step",
     *     summary="User activity statistic decrease step",
     *     tags={"User activities"},
     *     	 @OA\Parameter(
     *         description="date",
     *         in="query",
     *         name="date",
     *         required=true,
     *         example="1402/07/15",
     *         @OA\Schema(type="string"),
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
     *
     */
    public function decreaseStep ( Request $request ) {
        $request->validate([
                               'date' => [
                                   'required' ,
                                   'jdate' ,
                               ] ,
                           ]);
        $user = Auth::user();
        $date = $request->get('date');
        $step = UserActivity::query()
                            ->firstOrCreate([
                                                'date' => $date ,
                                                'user_id' => $user->id ,
                                                'type' => UserActivity::TYPES[ 'step' ] ,
                                            ]);
        if ( $step->count > 0 ) {
            $step->count = $step->count - 1;
        }
        else {
            $step->count = 0;
        }
        $step->save();

        return response()->json($user->statistic($date));
    }

    /**
     * @OA\Get(
     *     path="/api/user-activities/statistic",
     *     summary="User activity statistic",
     *     tags={"User activities"},
     *     	 @OA\Parameter(
     *         description="date",
     *         in="query",
     *         name="date",
     *         required=true,
     *         example="1402/07/15",
     *         @OA\Schema(type="string"),
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
     *
     */
    public function statistic ( Request $request ) {
        $request->validate([
                               'date' => [
                                   'required' ,
                                   'jdate' ,
                               ] ,
                           ]);
        $date = $request->get('date');
        $user = Auth::user();

        return response()->json($user->statistic($date));
    }

    /**
     * @OA\Get(
     *     path="/api/user-activities/current-month",
     *     summary="User activity statistic for current month",
     *     tags={"User activities"},
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
    public function currentMonth ( Request $request ) {
        $user = Auth::user();

        return response()->json($user->statisticOfCurrentMonth());
    }
}
