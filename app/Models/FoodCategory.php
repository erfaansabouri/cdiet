<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class FoodCategory extends Model implements HasMedia {
    use InteractsWithMedia;

    public function registerMediaCollections (): void {
        $this->addMediaCollection('image')
             ->singleFile();
    }

    public function food (): HasMany {
        return $this->hasMany(Food::class);
    }
}
