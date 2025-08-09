<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model {
    protected $with = [ 'replies' ];

    public function commentable () {
        return $this->morphTo();
    }

    public function user () {
        return $this->belongsTo(User::class);
    }

    public function scopeVerified ( Builder $query ): Builder {
        return $query->where('verified' , true);
    }

    public function replies () {
        return $this->hasMany(Comment::class , 'parent_id')
                    ->where('verified' , true)
                    ->orderBy('id');
    }

    public function parent () {
        return $this->belongsTo(Comment::class , 'parent_id');
    }
}
