<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Food extends Model implements HasMedia {
    use InteractsWithMedia;

    protected $table = 'food';
    protected $casts = [
        'calorie' => 'float' ,
        'carbohydrate' => 'float' ,
        'fat' => 'float' ,
        'protein' => 'float' ,
    ];

    public function registerMediaCollections (): void {
        $this->addMediaCollection('image')
             ->singleFile();
        $this->addMediaCollection('video')
             ->singleFile();
    }

    public function foodCategory (): BelongsTo {
        return $this->belongsTo(FoodCategory::class);
    }
}
