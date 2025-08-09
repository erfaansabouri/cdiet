<?php

namespace Database\Seeders;

use App\Models\ExerciseCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExerciseCategorySeeder extends Seeder {
    public function run (): void {
        ExerciseCategory::query()
                        ->firstOrCreate([
                                            'title' => 'حرکات ورزشی خاص' ,
                                            'premium' => true ,
                                        ]);

        ExerciseCategory::query()
                        ->firstOrCreate([
                                            'title' => 'حرکات شکم پهلو' ,
                                        ]);

        ExerciseCategory::query()
                        ->firstOrCreate([
                                            'title' => 'حرکات شکم پهلو' ,
                                        ]);

        ExerciseCategory::query()
                        ->firstOrCreate([
                                            'title' => 'حرکات پیلاتس' ,
                                        ]);

        ExerciseCategory::query()
                        ->firstOrCreate([
                                            'title' => 'حرکات یوگا' ,
                                        ]);
    }
}
