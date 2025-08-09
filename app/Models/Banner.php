<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Banner extends Model implements HasMedia {
    use InteractsWithMedia;

    const LOCATIONS = [
        'home' => 'home' ,
        'calorie-counter' => 'calorie-counter' ,
    ];
    const TARGETS = [
        'exercise-categories' => 'exercise-categories',
    ];

    public function registerMediaCollections (): void {
        $this->addMediaCollection('image')
             ->singleFile();
    }
}
