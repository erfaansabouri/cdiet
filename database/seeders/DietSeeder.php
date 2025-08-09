<?php

namespace Database\Seeders;

use App\Models\DietCategory;
use Faker\Factory;
use Illuminate\Database\Seeder;

class DietSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run (): void {
        foreach ( DietCategory::all() as $category ) {
            for ( $i = 0 ; $i < 30 ; $i++ ) {
                $category->diets()
                         ->create([
                                      'title' => Factory::create('fa_IR')->sentence ,
                                      'description' => Factory::create('fa_IR')->paragraph ,
                                  ]);
            }
        }
    }
}
