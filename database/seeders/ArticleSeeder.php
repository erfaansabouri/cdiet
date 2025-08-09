<?php

namespace Database\Seeders;

use App\Models\Article;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder {
    public function run (): void {
        for ( $i = 0 ; $i < 20 ; $i++ ) {
            $article = Article::query()
                   ->firstOrCreate([
                                       'title' => 'عنوان ' . $i + 1 ,
                                   ] , [
                                       'body' => Factory::create('fa_IR')->text ,
                                   ]);

            $article->addMediaFromUrl(asset('seeders/articles/1.png'))->toMediaCollection('image');
        }
    }
}
