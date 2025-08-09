<?php

namespace Database\Seeders;

use App\Models\ExerciseCategory;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExerciseSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run (): void {
        foreach ( ExerciseCategory::all() as $exercise_category ) {
            for ( $i = 0 ; $i < 30 ; $i++ ) {
                $exercise_category->exercises()
                                  ->create([
                                               'title' => Factory::create('fa_IR')->sentence ,
                                               'calorie' => rand(100 , 200) + 0.5 ,
                                               'description' => Factory::create('fa_IR')->paragraph ,
                                           ]);
            }
        }
    }
}
