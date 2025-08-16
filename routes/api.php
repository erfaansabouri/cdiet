<?php

use App\Http\Controllers\API\ArticleCommentController;
use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BannerController;
use App\Http\Controllers\API\DietaryCookingCategoryController;
use App\Http\Controllers\API\DietaryCookingCommentController;
use App\Http\Controllers\API\DietaryCookingController;
use App\Http\Controllers\API\DietaryCookingLikeController;
use App\Http\Controllers\API\DietCategoryController;
use App\Http\Controllers\API\DietController;
use App\Http\Controllers\API\ExerciseCategoryController;
use App\Http\Controllers\API\ExerciseCommentController;
use App\Http\Controllers\API\ExerciseController;
use App\Http\Controllers\API\ExerciseLikeController;
use App\Http\Controllers\API\FoodCategoryController;
use App\Http\Controllers\API\FoodController;
use App\Http\Controllers\API\FoodUnitController;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\MealtimeController;
use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\API\NoteController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\PlanController;
use App\Http\Controllers\API\RecommendedMealController;
use App\Http\Controllers\API\TermController;
use App\Http\Controllers\API\TicketCategoryController;
use App\Http\Controllers\API\TicketController;
use App\Http\Controllers\API\TicketReplyController;
use App\Http\Controllers\API\UserActivityController;
use App\Http\Controllers\API\VerifyTransactionController;
use App\Http\Controllers\API\WeightChangeLogController;
use App\Http\Middleware\DisableUserMiddleware;

Route::middleware([])
     ->prefix('auth')
     ->group(function () {
         Route::prefix('get-verification-code')
              ->group(function () {
                  Route::post('via-sms' , [
                      AuthController::class ,
                      'getVerificationCodeViaSms',
                  ]);
                  Route::post('via-email' , [
                      AuthController::class ,
                      'getVerificationCodeViaEmail',
                  ]);
              });
         Route::prefix('submit-verification-code')
              ->group(function () {
                  Route::post('via-sms' , [
                      AuthController::class ,
                      'submitVerificationCodeViaSms',
                  ]);
                  Route::post('via-email' , [
                      AuthController::class ,
                      'submitVerificationCodeViaEmail',
                  ]);
              });
         Route::post('verify-google-sign-in' , [
             AuthController::class ,
             'verifyGoogleSignIn',
         ]);
     });
Route::middleware([  ])
     ->group(function () {
         Route::middleware([ 'auth:api', DisableUserMiddleware::class ])
              ->prefix('profile')
              ->group(function () {
                  Route::get('show' , [
                      AuthController::class ,
                      'getProfile',
                  ]);
                  Route::post('update' , [
                      AuthController::class ,
                      'updateProfile',
                  ]);
                  Route::post('set-avatar' , [
                      AuthController::class ,
                      'setAvatar',
                  ]);
                  Route::post('update-firebase-token' , [
                      AuthController::class ,
                      'updateFirebaseToken',
                  ]);
                  Route::post('toggle-allow-notification' , [
                      AuthController::class ,
                      'toggleAllowNotification',
                  ]);
              });
         Route::middleware([ 'auth:api' ])
              ->prefix('home')
              ->group(function () {
                  Route::get('show' , [
                      HomeController::class ,
                      'show',
                  ]);
                  Route::get('texts' , [
                      HomeController::class ,
                      'texts',
                  ]);
              });
         Route::middleware([ 'auth:api' ])
              ->prefix('banners')
              ->group(function () {
                  Route::get('index' , [
                      BannerController::class ,
                      'index',
                  ]);
              });
         Route::middleware([ 'auth:api' ])
              ->prefix('food-units')
              ->group(function () {
                  Route::get('index' , [
                      FoodUnitController::class ,
                      'index',
                  ])
                       ->name('food-units.index');
              });
         Route::middleware([ 'auth:api' ])
              ->prefix('terms')
              ->group(function () {
                  Route::get('show' , [
                      TermController::class ,
                      'show',
                  ]);
                  Route::put('accept' , [
                      TermController::class ,
                      'accept',
                  ]);
              });
         Route::middleware([ 'auth:api' ])
              ->prefix('notes')
              ->group(function () {
                  Route::get('index' , [
                      NoteController::class ,
                      'index',
                  ]);
                  Route::post('store' , [
                      NoteController::class ,
                      'store',
                  ]);
                  Route::put('update/{id}' , [
                      NoteController::class ,
                      'update',
                  ]);
              });
         Route::middleware([ 'auth:api' ])
              ->prefix('articles')
              ->group(function () {
                  Route::get('index' , [
                      ArticleController::class ,
                      'index',
                  ])
                       ->name('articles.index');
                  Route::get('show/{id}' , [
                      ArticleController::class ,
                      'show',
                  ]);
              });
         Route::middleware([ 'auth:api' ])
              ->prefix('article-comments')
              ->group(function () {
                  Route::get('index' , [
                      ArticleCommentController::class ,
                      'index',
                  ]);
                  Route::post('store' , [
                      ArticleCommentController::class ,
                      'store',
                  ]);
              });
         Route::middleware([ 'auth:api' ])
              ->prefix('ticket-categories')
              ->group(function () {
                  Route::get('index' , [
                      TicketCategoryController::class ,
                      'index',
                  ]);
              });
         Route::middleware([ 'auth:api' ])
              ->prefix('tickets')
              ->group(function () {
                  Route::get('index' , [
                      TicketController::class ,
                      'index',
                  ]);
                  Route::post('store' , [
                      TicketController::class ,
                      'store',
                  ]);
              });
         Route::middleware([ 'auth:api' ])
              ->prefix('ticket-replies')
              ->group(function () {
                  Route::get('index' , [
                      TicketReplyController::class ,
                      'index',
                  ]);
                  Route::post('store' , [
                      TicketReplyController::class ,
                      'store',
                  ]);
              });
         Route::middleware([ 'auth:api' ])
              ->prefix('exercise-categories')
              ->group(function () {
                  Route::get('index' , [
                      ExerciseCategoryController::class ,
                      'index',
                  ])
                       ->name('exercise-categories.index');
                  Route::get('premium/index' , [
                      ExerciseCategoryController::class ,
                      'premiumIndex',
                  ])
                       ->name('exercise-categories.premium-index');
              });
         Route::middleware([ 'auth:api' ])
              ->prefix('exercises')
              ->group(function () {
                  Route::get('all' , [
                      ExerciseController::class ,
                      'all',
                  ]);
                  Route::get('index' , [
                      ExerciseController::class ,
                      'index',
                  ]);
              });
         Route::middleware([ 'auth:api' ])
              ->prefix('exercise-likes')
              ->group(function () {
                  Route::put('like/{exercise_id}' , [
                      ExerciseLikeController::class ,
                      'like',
                  ]);
                  Route::put('unlike/{exercise_id}' , [
                      ExerciseLikeController::class ,
                      'unlike',
                  ]);
              });
         Route::middleware([ 'auth:api' ])
              ->prefix('exercise-comments')
              ->group(function () {
                  Route::get('index' , [
                      ExerciseCommentController::class ,
                      'index',
                  ]);
                  Route::post('store' , [
                      ExerciseCommentController::class ,
                      'store',
                  ]);
              });
         Route::middleware([ 'auth:api' ])
              ->prefix('notifications')
              ->group(function () {
                  Route::get('index' , [
                      NotificationController::class ,
                      'index',
                  ]);
                  Route::put('read/{id}' , [
                      NotificationController::class ,
                      'read',
                  ]);
              });
         Route::middleware([ 'auth:api' ])
              ->prefix('dietary-cooking-categories')
              ->group(function () {
                  Route::get('index' , [
                      DietaryCookingCategoryController::class ,
                      'index',
                  ])
                       ->name('dietary-cooking-categories.index');
              });
         Route::middleware([ 'auth:api' ])
              ->prefix('dietary-cookings')
              ->group(function () {
                  Route::get('index' , [
                      DietaryCookingController::class ,
                      'index',
                  ]);
              });
         Route::middleware([ 'auth:api' ])
              ->prefix('dietary-cooking-likes')
              ->group(function () {
                  Route::put('like/{dietary_cooking_id}' , [
                      DietaryCookingLikeController::class ,
                      'like',
                  ]);
                  Route::put('unlike/{dietary_cooking_id}' , [
                      DietaryCookingLikeController::class ,
                      'unlike',
                  ]);
              });
         Route::middleware([ 'auth:api' ])
              ->prefix('dietary-cooking-comments')
              ->group(function () {
                  Route::get('index' , [
                      DietaryCookingCommentController::class ,
                      'index',
                  ]);
                  Route::post('store' , [
                      DietaryCookingCommentController::class ,
                      'store',
                  ]);
              });
         Route::middleware([ 'auth:api' ])
              ->prefix('diet-categories')
              ->group(function () {
                  Route::get('index' , [
                      DietCategoryController::class ,
                      'index',
                  ])
                       ->name('diet-categories.index');
              });
         Route::middleware([ 'auth:api' ])
              ->prefix('diets')
              ->group(function () {
                  Route::get('index' , [
                      DietController::class ,
                      'index',
                  ]);
              });
         Route::middleware([ 'auth:api' ])
              ->prefix('food-categories')
              ->group(function () {
                  Route::get('index' , [
                      FoodCategoryController::class ,
                      'index',
                  ]);
              });
         Route::middleware([ 'auth:api' ])
              ->prefix('food')
              ->group(function () {
                  Route::get('index' , [
                      FoodController::class ,
                      'index',
                  ]);
                  Route::get('all' , [
                      FoodController::class ,
                      'all',
                  ]);
              });
         Route::middleware([ 'auth:api' ])
              ->prefix('user-activities')
              ->group(function () {
                  Route::get('statistic' , [
                      UserActivityController::class ,
                      'statistic',
                  ]);
                  Route::get('current-month' , [
                      UserActivityController::class ,
                      'currentMonth',
                  ]);
                  Route::post('add-food' , [
                      UserActivityController::class ,
                      'addFood',
                  ]);
                  Route::post('add-calorie' , [
                      UserActivityController::class ,
                      'addCalorie',
                  ]);
                  Route::post('burn-calorie' , [
                      UserActivityController::class ,
                      'burnCalorie',
                  ]);
                  Route::post('add-calorie-by-mealtime-weekday' , [
                      UserActivityController::class ,
                      'addCalorieByMealtimeWeekday',
                  ]);
                  Route::post('add-exercise' , [
                      UserActivityController::class ,
                      'addExercise',
                  ]);
                  Route::post('did-an-exercise-set' , [
                      UserActivityController::class ,
                      'didAnExerciseSet',
                  ]);
                  Route::put('increase-drink-water' , [
                      UserActivityController::class ,
                      'increaseDrinkWater',
                  ]);
                  Route::put('decrease-drink-water' , [
                      UserActivityController::class ,
                      'decreaseDrinkWater',
                  ]);
                  Route::put('manual-step' , [
                      UserActivityController::class ,
                      'manualStep',
                  ]);
                  Route::put('increase-step' , [
                      UserActivityController::class ,
                      'increaseStep',
                  ]);
                  Route::put('decrease-step' , [
                      UserActivityController::class ,
                      'decreaseStep',
                  ]);
              });
         Route::middleware([ 'auth:api' ])
              ->prefix('plans')
              ->group(function () {
                  Route::get('index' , [
                      PlanController::class ,
                      'index',
                  ]);
              });
         Route::middleware([ 'auth:api' ])
              ->prefix('verify-transactions')
              ->group(function () {
                  Route::post('myket' , [
                      VerifyTransactionController::class ,
                      'myket',
                  ]);
                  Route::post('bazaar' , [
                      VerifyTransactionController::class ,
                      'bazaar',
                  ]);
              });
         Route::middleware([ 'auth:api' ])
              ->prefix('recommended-meals')
              ->group(function () {
                  Route::get('index' , [
                      RecommendedMealController::class ,
                      'index',
                  ]);
              });
         Route::middleware([ 'auth:api' ])
              ->prefix('mealtimes')
              ->group(function () {
                  Route::get('index' , [
                      MealtimeController::class ,
                      'index',
                  ]);
              });
         Route::middleware([ 'auth:api' ])
              ->prefix('weight-change-logs')
              ->group(function () {
                  Route::get('chart' , [
                      WeightChangeLogController::class ,
                      'chart',
                  ]);
              });

         Route::middleware([ 'auth:api' ])
              ->prefix('messages')
              ->group(function () {
                  Route::get('index' , [
                      MessageController::class ,
                      'index',
                  ]);
                  Route::post('send' , [
                      MessageController::class ,
                      'send',
                  ]);
              });
     });

