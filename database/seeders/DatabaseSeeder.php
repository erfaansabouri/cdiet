<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    public function run (): void {
        $this->call(FoodUnitSeeder::class);
        $this->call(TermSeeder::class);
        $this->call(ArticleSeeder::class);
        $this->call(TicketCategorySeeder::class);
        $this->call(TicketStatusSeeder::class);
        $this->call(ExerciseCategorySeeder::class);
        $this->call(DietaryCookingCategorySeeder::class);
        $this->call(ExerciseSeeder::class);
        $this->call(DietaryCookingSeeder::class);
        $this->call(DietCategorySeeder::class);
        $this->call(DietSeeder::class);
        $this->call(BannerSeeder::class);
        $this->call(FoodCategorySeeder::class);
        $this->call(FoodSeeder::class);
        $this->call(PlanSeeder::class);
        $this->call(RecommendedMealSeeder::class);
    }
}
