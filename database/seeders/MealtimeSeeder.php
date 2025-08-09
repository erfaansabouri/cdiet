<?php

namespace Database\Seeders;

use App\Models\Mealtime;
use App\Models\MealtimeWeekday;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MealtimeSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run (): void {
        // 4تا میل تایم بساز صبحانه ناهار میان وعده شام
        $mealtimes = [
            [
                'title' => 'صبحانه' ,
                'subtitle' => 'صبحانه' ,
                'hours' => '08:00 - 10:00' ,
                'calorie' => 300 ,
                'description' => 'صبحانه کامل و مقوی برای شروع روز' ,
                'mealtime_weekdays' => [
                    [
                        'title' => 'شنبه' ,
                        'subtitle' => 'صبحانه شنبه' ,
                        'description' => 'صبحانه مخصوص روز شنبه' ,
                        'calorie' => 300 ,
                    ] ,
                    [
                        'title' => 'یکشنبه' ,
                        'subtitle' => 'صبحانه یکشنبه' ,
                        'description' => 'صبحانه مخصوص روز یکشنبه' ,
                        'calorie' => 300 ,
                    ] ,
                    [
                        'title' => 'دوشنبه' ,
                        'subtitle' => 'صبحانه دوشنبه' ,
                        'description' => 'صبحانه مخصوص روز دوشنبه' ,
                        'calorie' => 300 ,
                    ] ,
                    [
                        'title' => 'سه‌شنبه' ,
                        'subtitle' => 'صبحانه سه‌شنبه' ,
                        'description' => 'صبحانه مخصوص روز سه‌شنبه' ,
                        'calorie' => 300 ,
                    ] ,
                    [
                        'title' => 'چهارشنبه' ,
                        'subtitle' => 'صبحانه چهارشنبه' ,
                        'description' => 'صبحانه مخصوص روز چهارشنبه' ,
                        'calorie' => 300 ,
                    ] ,
                    [
                        'title' => 'پنج‌شنبه' ,
                        'subtitle' => 'صبحانه پنج‌شنبه' ,
                        'description' => 'صبحانه مخصوص روز پنج‌شنبه' ,
                        'calorie' => 300 ,
                    ] ,
                    [
                        'title' => 'جمعه' ,
                        'subtitle' => 'صبحانه جمعه' ,
                        'description' => 'صبحانه مخصوص روز جمعه' ,
                        'calorie' => 300 ,
                    ] ,
                ],
            ] ,
            [
                'title' => 'ناهار' ,
                'subtitle' => 'ناهار' ,
                'hours' => '12:00 - 14:00' ,
                'calorie' => 600 ,
                'description' => 'ناهار خوشمزه و سیر کننده' ,
                'mealtime_weekdays' => [
                    [
                        'title' => 'شنبه' ,
                        'subtitle' => 'ناهار شنبه' ,
                        'description' => 'ناهار مخصوص روز شنبه' ,
                        'calorie' => 600 ,
                    ] ,
                    [
                        'title' => 'یکشنبه' ,
                        'subtitle' => 'ناهار یکشنبه' ,
                        'description' => 'ناهار مخصوص روز یکشنبه' ,
                        'calorie' => 600 ,
                    ] ,
                    [
                        'title' => 'دوشنبه' ,
                        'subtitle' => 'ناهار دوشنبه' ,
                        'description' => 'ناهار مخصوص روز دوشنبه' ,
                        'calorie' => 600 ,
                    ] ,
                    [
                        'title' => 'سه‌شنبه' ,
                        'subtitle' => 'ناهار سه‌شنبه' ,
                        'description' => 'ناهار مخصوص روز سه‌شنبه' ,
                        'calorie' => 600 ,
                    ] ,
                    [
                        'title' => 'چهارشنبه' ,
                        'subtitle' => 'ناهار چهارشنبه' ,
                        'description' => 'ناهار مخصوص روز چهارشنبه' ,
                        'calorie' => 600 ,
                    ] ,
                    [
                        'title' => 'پنج‌شنبه' ,
                        'subtitle' => 'ناهار پنج‌شنبه' ,
                        'description' => 'ناهار مخصوص روز پنج‌شنبه' ,
                        'calorie' => 600 ,
                    ] ,
                    [
                        'title' => 'جمعه' ,
                        'subtitle' => 'ناهار جمعه' ,
                        'description' => 'ناهار مخصوص روز جمعه' ,
                        'calorie' => 600 ,
                    ] ,
                ],
            ] ,
            [
                'title' => 'میان وعده' ,
                'subtitle' => 'میان وعده' ,
                'hours' => '16:00 - 17:00' ,
                'calorie' => 200 ,
                'description' => 'میان وعده سبک و سالم' ,
                'mealtime_weekdays' => [
                    [
                        'title' => 'شنبه' ,
                        'subtitle' => 'میان وعده شنبه' ,
                        'description' => 'میان وعده مخصوص روز شنبه' ,
                        'calorie' => 200 ,
                    ] ,
                    [
                        'title' => 'یکشنبه' ,
                        'subtitle' => 'میان وعده یکشنبه' ,
                        'description' => 'میان وعده مخصوص روز یکشنبه' ,
                        'calorie' => 200 ,
                    ] ,
                    [
                        'title' => 'دوشنبه' ,
                        'subtitle' => 'میان وعده دوشنبه' ,
                        'description' => 'میان وعده مخصوص روز دوشنبه' ,
                        'calorie' => 200 ,
                    ] ,
                    [
                        'title' => 'سه‌شنبه' ,
                        'subtitle' => 'میان وعده سه‌شنبه' ,
                        'description' => 'میان وعده مخصوص روز سه‌شنبه' ,
                        'calorie' => 200 ,
                    ] ,
                    [
                        'title' => 'چهارشنبه' ,
                        'subtitle' => 'میان وعده چهارشنبه' ,
                        'description' => 'میان وعده مخصوص روز چهارشنبه' ,
                        'calorie' => 200 ,
                    ] ,
                    [
                        'title' => 'پنج‌شنبه' ,
                        'subtitle' => 'میان وعده پنج‌شنبه' ,
                        'description' => 'میان وعده مخصوص روز پنج‌شنبه' ,
                        'calorie' => 200 ,
                    ] ,
                    [
                        'title' => 'جمعه' ,
                        'subtitle' => 'میان وعده جمعه' ,
                        'description' => 'میان وعده مخصوص روز جمعه' ,
                        'calorie' => 200 ,
                    ] ,
                ],
            ] ,
            [
                'title' => 'شام' ,
                'subtitle' => 'شام' ,
                'hours' => '20:00 - 22:00' ,
                'calorie' => 500 ,
                'description' => 'شام لذیذ و آرامش بخش' ,
                'mealtime_weekdays' => [
                    [
                        'title' => 'شنبه' ,
                        'subtitle' => 'شام شنبه' ,
                        'description' => 'شام مخصوص روز شنبه' ,
                        'calorie' => 500 ,
                    ] ,
                    [
                        'title' => 'یکشنبه' ,
                        'subtitle' => 'شام یکشنبه' ,
                        'description' => 'شام مخصوص روز یکشنبه' ,
                        'calorie' => 500 ,
                    ] ,
                    [
                        'title' => 'دوشنبه' ,
                        'subtitle' => 'شام دوشنبه' ,
                        'description' => 'شام مخصوص روز دوشنبه' ,
                        'calorie' => 500 ,
                    ] ,
                    [
                        'title' => 'سه‌شنبه' ,
                        'subtitle' => 'شام سه‌شنبه' ,
                        'description' => 'شام مخصوص روز سه‌شنبه' ,
                        'calorie' => 500 ,
                    ] ,
                    [
                        'title' => 'چهارشنبه' ,
                        'subtitle' => 'شام چهارشنبه' ,
                        'description' => 'شام مخصوص روز چهارشنبه' ,
                        'calorie' => 500 ,
                    ] ,
                    [
                        'title' => 'پنج‌شنبه' ,
                        'subtitle' => 'شام پنج‌شنبه' ,
                        'description' => 'شام مخصوص روز پنج‌شنبه' ,
                        'calorie' => 500 ,
                    ] ,
                    [
                        'title' => 'جمعه' ,
                        'subtitle' => 'شام جمعه' ,
                        'description' => 'شام مخصوص روز جمعه' ,
                        'calorie' => 500 ,
                    ] ,
                ],
            ] ,
        ];
        Mealtime::truncate();
        MealtimeWeekday::truncate();
        foreach ( $mealtimes as $mealtimeData ) {
            $mealtime = Mealtime::create([
                                                         'title' => $mealtimeData[ 'title' ] ,
                                                         'subtitle' => $mealtimeData[ 'subtitle' ] ,
                                                         'hours' => $mealtimeData[ 'hours' ] ,
                                                         'calorie' => $mealtimeData[ 'calorie' ] ,
                                                         'description' => $mealtimeData[ 'description' ] ,
                                                     ]);
            foreach ( $mealtimeData[ 'mealtime_weekdays' ] as $weekdayData ) {
                $mealtime->mealtimeWeekdays()
                         ->create([
                                      'title' => $weekdayData[ 'title' ] ,
                                      'subtitle' => $weekdayData[ 'subtitle' ] ,
                                      'description' => $weekdayData[ 'description' ] ,
                                      'calorie' => $weekdayData[ 'calorie' ] ,
                                  ]);
            }
        }
    }
}
