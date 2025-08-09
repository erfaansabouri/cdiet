<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder {
    public function run (): void {
        $banner = Banner::query()
                        ->firstOrCreate([
                                            'title' => 'home-1' ,
                                            'location' => Banner::LOCATIONS[ 'home' ] ,
                                            'target' => Banner::TARGETS[ 'exercise-categories' ] ,
                                        ]);
        $banner->addMediaFromUrl(asset('seeders/banners/banner-home-1.png'))
               ->toMediaCollection('image');
    }
}
