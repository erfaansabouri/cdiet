<?php

namespace Database\Seeders;

use App\Models\RecommendedMeal;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class RecommendedMealSeeder extends Seeder {
    public function run (): void {
        RecommendedMeal::truncate();
        foreach ( array_values(User::GOALS) as $goal ) {
            RecommendedMeal::query()
                           ->firstOrCreate([ 'title' => 'صبحانه', 'goal' => $goal ] , [
                               'subtitle' => 'بهترین زمان مصرف این وعده برای شما' ,
                               'hours' => ' بین ساعت 7 الی 9' ,
                               'description' => Factory::create('fa_IR')->sentence ,
                           ])
                           ->addMediaFromUrl(asset('seeders/recommended-meals/1.png'))
                           ->toMediaCollection('image');
            RecommendedMeal::query()
                           ->firstOrCreate([ 'title' => 'ناهار' ,  'goal' => $goal] , [
                               'subtitle' => 'بهترین زمان مصرف این وعده برای شما' ,
                               'hours' => ' بین ساعت 12 الی 14' ,
                               'description' => Factory::create('fa_IR')->sentence ,
                           ])
                           ->addMediaFromUrl(asset('seeders/recommended-meals/2.png'))
                           ->toMediaCollection('image');
            RecommendedMeal::query()
                           ->firstOrCreate([ 'title' => 'میان وعده',  'goal' => $goal ] , [
                               'subtitle' => 'بهترین زمان مصرف این وعده برای شما' ,
                               'hours' => ' بین ساعت 18 الی 19' ,
                               'description' => Factory::create('fa_IR')->sentence ,
                           ])
                           ->addMediaFromUrl(asset('seeders/recommended-meals/3.png'))
                           ->toMediaCollection('image');
            RecommendedMeal::query()
                           ->firstOrCreate([ 'title' => 'شام',  'goal' => $goal ] , [
                               'subtitle' => 'بهترین زمان مصرف این وعده برای شما' ,
                               'hours' => ' بین ساعت 20 الی 21' ,
                               'description' => Factory::create('fa_IR')->sentence ,
                           ])
                           ->addMediaFromUrl(asset('seeders/recommended-meals/4.png'))
                           ->toMediaCollection('image');
        }
    }
}
