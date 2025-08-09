<?php

namespace Database\Seeders;

use App\Models\FoodUnit;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FoodUnitSeeder extends Seeder {
    public function run (): void {
        $items = [
            'قاشق' ,
            'قاشق مربا خوری' ,
            'قاشق چای خوری' ,
            'کف گیر' ,
            'سیخ' ,
            'کف دست' ,
            'لیوان' ,
            'حبه' ,
            'ساشه' ,
        ];
        foreach ( $items as $key => $item ) {
            $food_unit = FoodUnit::query()
                                 ->firstOrCreate([
                                                     'title' => $item ,
                                                 ] , [
                                                     'description' => Factory::create('fa_IR')->paragraph ,
                                                 ]);
            $name = $key + 1;
            $food_unit->addMediaFromUrl(asset("seeders/food-units/$name.png"))->toMediaCollection('image');
        }
    }
}
