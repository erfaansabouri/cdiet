<?php

namespace App\Traits;

use App\Models\Like;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Auth;

trait Likeable {
    /**
     * Define the polymorphic relationship for likes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function likes () {
        return $this->morphMany(Like::class , 'likeable');
    }

    /**
     * Add a like to the model.
     *
     * @param int|null $user_id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function like ( $user_id = null ) {
        $user_id = $user_id ? : auth()->id();

        return $this->likes()
                    ->firstOrCreate([ 'user_id' => $user_id ]);
    }

    /**
     * Remove a like from the model.
     *
     * @param int|null $user_id
     * @return bool
     */
    public function unlike ( $user_id = null ) {
        $user_id = $user_id ? : auth()->id();
        // Find and delete the like
        $like = $this->likes()
                     ->where('user_id' , $user_id)
                     ->first();
        if ( $like ) {
            $like->delete();

            return true;
        }

        return false; // Return false if the like doesn't exist
    }

    protected function likedByMe (): Attribute {
        return Attribute::make(get: fn () => (bool)$this->likes()
                                                        ->where('user_id' , Auth::guard('api')
                                                                                ->user()->id)
                                                        ->first());
    }
}
