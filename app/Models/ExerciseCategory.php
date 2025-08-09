<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ExerciseCategory extends Model implements HasMedia {
    use InteractsWithMedia;

    protected $casts = [
        'premium' => 'boolean' ,
    ];

    public function registerMediaCollections (): void {
        $this->addMediaCollection('image')
             ->singleFile();
    }

    public function exercises (): HasMany {
        return $this->hasMany(Exercise::class);
    }

    public function scopePremium ( Builder $query ): Builder {
        return $query->where('premium' , true);
    }

    public function scopeNotPremium ( Builder $query ): Builder {
        return $query->where('premium' , '!=' , true);
    }
}
