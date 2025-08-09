<?php

namespace Database\Seeders;

use App\Models\DietCategory;
use Illuminate\Database\Seeder;

class DietCategorySeeder extends Seeder {
    public function run (): void {
        DietCategory::query()
                        ->firstOrCreate([
                                            'title' => 'برنامه کتونژیک' ,
                                        ]);

        DietCategory::query()
                        ->firstOrCreate([
                                            'title' => 'برنامه فستینگ' ,
                                        ]);

        DietCategory::query()
                        ->firstOrCreate([
                                            'title' => 'برنامه سفر خانواده' ,
                                        ]);

        DietCategory::query()
                        ->firstOrCreate([
                                            'title' => 'برنامه روزه داری' ,
                                        ]);

        DietCategory::query()
                        ->firstOrCreate([
                                            'title' => 'برنامه ماهانه' ,
                                        ]);
    }
}
