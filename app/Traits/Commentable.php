<?php

namespace App\Traits;

use App\Models\Comment;

trait Commentable {
    /**
     * Define the polymorphic relationship for comments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments () {
        return $this->morphMany(Comment::class , 'commentable')
                    ->whereNull('parent_id');
    }

    /**
     * Add a comment to the model.
     *
     * @param string   $body
     * @param int|null $user_id
     * @return \Illuminate\Database\Eloquent\Model
     */
    /**
     * add a comment or reply
     *
     * @param string   $text
     * @param int|null $userId
     * @param int|null $parentId // pass to make this a reply
     * @return Comment
     */
    public function addComment ( string $text , int $parentId = null ) {
        $userId = auth()->id();
        $attributes = [
            'user_id' => $userId ,
            'text' => $text ,
        ];
        if ( !is_null($parentId) ) {
            $attributes[ 'parent_id' ] = $parentId;
        }

        return $this->comments()
                    ->create($attributes);
    }
}
