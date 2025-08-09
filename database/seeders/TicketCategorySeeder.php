<?php

namespace Database\Seeders;

use App\Models\TicketCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketCategorySeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run (): void {
        TicketCategory::query()
                      ->firstOrCreate([
                                          'title' => 'نرم افزار' ,
                                      ]);
        TicketCategory::query()
                      ->firstOrCreate([
                                          'title' => 'تغذیه' ,
                                          'premium' => true ,
                                      ]);
        TicketCategory::query()
                      ->firstOrCreate([
                                          'title' => 'ورزشی' ,
                                          'premium' => true ,
                                      ]);
    }
}
