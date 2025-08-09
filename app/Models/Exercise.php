<?php

namespace App\Models;

use App\Traits\Commentable;
use App\Traits\Likeable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Exercise extends Model implements HasMedia {
    use InteractsWithMedia , Likeable , Commentable;

    protected $casts = [
        'calorie' => 'float' ,
    ];

    public function exerciseCategory (): BelongsTo {
        return $this->belongsTo(ExerciseCategory::class);
    }

    public function registerMediaCollections (): void {
        $this->addMediaCollection('image')
             ->singleFile();
        $this->addMediaCollection('video')
             ->singleFile();
        $this->addMediaCollection('gif')
             ->singleFile();
    }
}
