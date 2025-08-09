<?php

namespace Database\Seeders;

use App\Models\TicketStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketStatusSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run (): void {
        TicketStatus::query()
                    ->create([
                                 'title' => 'در انتظار پاسخ' ,
                             ]);

        TicketStatus::query()
                    ->create([
                                 'title' => 'پاسخ داده شده' ,
                             ]);

        TicketStatus::query()
                    ->create([
                                 'title' => 'بسته شده' ,
                             ]);
    }
}
