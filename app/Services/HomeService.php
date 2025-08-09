<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Banner;
use App\Models\Diet;
use App\Models\DietaryCooking;
use App\Models\Exercise;
use App\Models\FoodUnit;
use App\Models\HomeMenuItem;
use Illuminate\Support\Facades\Cache;

class HomeService {
    public function banners () {
        return Cache::store('file')
                    ->remember('home-banners' , 60 , function () {
                        return Banner::query()
                                     ->where('location' , Banner::LOCATIONS[ 'home' ])
                                     ->get();
                    });
    }

    public function homeMenuItems () {
        return Cache::store('file')
                    ->remember('home-menu-items' , 60 , function () {
                        $exercises_count = Exercise::count();
                        $diets_count = Diet::count();
                        $articles_count = Article::count();
                        $dietary_cookings_count = DietaryCooking::count();
                        $food_units_count = FoodUnit::count();
                        $collection = collect([]);
                        $collection->add(new HomeMenuItem([
                                                              'title' => 'بانک حرکات' ,
                                                              'subtitle' => "(تعداد $exercises_count حرکت پیشنهادی)" ,
                                                              'image_url' => asset('seeders/home-menu-items/ic_home_categories_exercises.png') ,
                                                              'redirect_to' => 'exercises' ,
                                                          ]));
                        $collection->add(new HomeMenuItem([
                                                              'title' => 'برنامه غذایی' ,
                                                              'subtitle' => "(تعداد $diets_count برنامه پیشنهادی)" ,
                                                              'image_url' => asset('seeders/home-menu-items/ic_home_categories_diet.png') ,
                                                              'redirect_to' => 'diets' ,
                                                          ]));
                        $collection->add(new HomeMenuItem([
                                                              'title' => 'مجله سلامتی' ,
                                                              'subtitle' => "(تعداد $articles_count خبر جدید)" ,
                                                              'image_url' => asset('seeders/home-menu-items/ic_home_categories_health_journal.png') ,
                                                              'redirect_to' => 'health_journal' ,
                                                          ]));
                        $collection->add(new HomeMenuItem([
                                                              'title' => 'آشپزی رژیمی' ,
                                                              'subtitle' => "(تعداد $dietary_cookings_count سبک پیشنهادی)" ,
                                                              'image_url' => asset('seeders/home-menu-items/ic_home_categories_diet_recipes.png') ,
                                                              'redirect_to' => 'dietary_recipes' ,
                                                          ]));
                        $collection->add(new HomeMenuItem([
                                                              'title' => 'واحد غذایی' ,
                                                              'subtitle' => "(تعداد $food_units_count واحد مختلف)" ,
                                                              'image_url' => asset('seeders/home-menu-items/ic_home_categories_food_units.png') ,
                                                              'redirect_to' => 'food_units' ,
                                                          ]));

                        return $collection;
                    });
    }
}
