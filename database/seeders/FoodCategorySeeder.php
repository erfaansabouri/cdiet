<?php

namespace Database\Seeders;

use App\Models\FoodCategory;
use Illuminate\Database\Seeder;

class FoodCategorySeeder extends Seeder {
    public function run (): void {
        $items = [
            'نان و غلات' ,
            'برنج و ماکارونی' ,
            'میوه' ,
            'گوشت' ,
            'لبنیات' ,
            'سبزی' ,
            'فست فود' ,
            'نوشیدنی' ,
            'میان وعده' ,
            'چاشنی و سس' ,
            'شیرینی و دسر' ,
            'سالاد' ,
        ];
        foreach ( $items as $key => $item ) {
            $food_category = FoodCategory::query()
                                         ->firstOrCreate([
                                                             'title' => $item ,
                                                         ]);
            $number = $key + 1;
            $food_category->addMediaFromUrl(asset("seeders/food-categories/{$number}.png"))->toMediaCollection('image');
        }
    }
}
