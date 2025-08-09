<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run (): void {
        Plan::query()
            ->firstOrCreate([
                                'text_1' => 'اشتراک' ,
                                'text_2' => 'یک ماهه' ,
                                'text_3' => 'دسترسی به پشتیبانی غذایی و پنل هدف گذاری تخصصی' ,
                                'days' => 30 ,
                                'myket_plan_id' => 'M1' ,
                                'bazaar_plan_id' => 'B1' ,
                            ]);
        Plan::query()
            ->firstOrCreate([
                                'text_1' => 'اشتراک' ,
                                'text_2' => 'دو ماهه' ,
                                'text_3' => 'دسترسی به پشتیبانی غذایی و پنل هدف گذاری تخصصی' ,
                                'days' => 60 ,
                                'myket_plan_id' => 'M2' ,
                                'bazaar_plan_id' => 'B2' ,
                            ]);
        Plan::query()
            ->firstOrCreate([
                                'text_1' => 'اشتراک' ,
                                'text_2' => 'سه ماهه' ,
                                'text_3' => 'دسترسی به پشتیبانی غذایی و پنل هدف گذاری تخصصی' ,
                                'days' => 90 ,
                                'myket_plan_id' => 'M3' ,
                                'bazaar_plan_id' => 'B3' ,
                            ]);
    }
}
