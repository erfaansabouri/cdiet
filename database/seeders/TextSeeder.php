<?php

namespace Database\Seeders;

use App\Models\Text;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TextSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run (): void {
        Text::query()
            ->create([
                         'key' => 'a' ,
                         'value' => 'دسته بندی ما' ,
                     ]);

        Text::query()
            ->create([
                         'key' => 'b' ,
                         'value' => 'وعده های جمعه ، اینجا میتونی با سلیقه انتخابی خودت و نوع فعالیت امروزت وعده هاتو بچینی' ,
                     ]);

        Text::query()
            ->create([
                         'key' => 'c' ,
                         'value' => 'هشدار ! مصرف کمتر از کالری مورد نیاز بدن شما موجب آسیب به رژیم غذایی و تناسب اندام شما می شود.' ,
                     ]);

        Text::query()
            ->create([
                         'key' => 'd' ,
                         'value' => 'عملکردت عالی بود و برای سلامتی بیشتر پیشنهاد میکنیم 6 تا 8 لیوان آب بنوشید' ,
                     ]);


        Text::query()
            ->create([
                         'key' => 'e' ,
                         'value' => 'عملکردت عالی بود و برای سلامتی بیشتر پیشنهاد میکنیم روزانه 3000 قدم بردارید. ' ,
                     ]);


        Text::query()
            ->create([
                         'key' => 'f' ,
                         'value' => 'عملکرد شما برای این ماه عالی بود ! ادامه بده ' ,
                     ]);


        Text::query()
            ->create([
                         'key' => 'g' ,
                         'value' => 'متن قسمت اندازه فونت ' ,
                     ]);

    }
}
