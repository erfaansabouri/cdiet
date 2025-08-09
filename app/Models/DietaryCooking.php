<?php

namespace App\Models;

use App\Traits\Commentable;
use App\Traits\Likeable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class DietaryCooking extends Model implements HasMedia {
    use InteractsWithMedia , Likeable , Commentable;

    public function registerMediaCollections (): void {
        $this->addMediaCollection('image')
             ->singleFile();
        $this->addMediaCollection('video')
             ->singleFile();
    }

    public function dietaryCookingCategory (): BelongsTo {
        return $this->belongsTo(DietaryCookingCategory::class);
    }
}
