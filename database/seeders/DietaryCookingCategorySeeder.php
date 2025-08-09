<?php

namespace Database\Seeders;

use App\Models\DietaryCookingCategory;
use Illuminate\Database\Seeder;

class DietaryCookingCategorySeeder extends Seeder {
    public function run (): void {
        DietaryCookingCategory::query()
                        ->firstOrCreate([
                                            'title' => 'کیک رژیمی' ,
                                        ]);

        DietaryCookingCategory::query()
                        ->firstOrCreate([
                                            'title' => 'صبحانه رژیمی' ,
                                        ]);

        DietaryCookingCategory::query()
                        ->firstOrCreate([
                                            'title' => 'میان وعده رژیمی' ,
                                        ]);

        DietaryCookingCategory::query()
                        ->firstOrCreate([
                                            'title' => 'ناهار رژیمی' ,
                                        ]);

        DietaryCookingCategory::query()
                        ->firstOrCreate([
                                            'title' => 'میان وعده رژیمی' ,
                                        ]);
    }
}
