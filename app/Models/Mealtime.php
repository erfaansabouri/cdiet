<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Mealtime extends Model implements HasMedia {
    use InteractsWithMedia;

    public function registerMediaCollections (): void {
        $this->addMediaCollection('image')
             ->singleFile();
    }

    public function mealtimeWeekdays (): HasMany {
        return $this->hasMany(MealtimeWeekday::class , 'mealtime_id');
    }
}
