<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Diet extends Model implements HasMedia {
    use InteractsWithMedia;

    public function dietCategory (): BelongsTo {
        return $this->belongsTo(DietCategory::class);
    }

    public function registerMediaCollections (): void {
        $this->addMediaCollection('image')
             ->singleFile();
        $this->addMediaCollection('video')
             ->singleFile();
    }
}
