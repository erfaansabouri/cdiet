<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExerciseResource extends JsonResource {
    public function toArray ( Request $request ): array {
        return [
            'id' => $this->id ,
            'title' => $this->title ,
            'calorie' => $this->calorie,
            'summary' => $this->summary ,
            'description' => $this->description ,
            'image_url' => $this->getFirstMediaUrl('image') ,
            'video_url' => $this->getFirstMediaUrl('video') ,
            'gif_url' => $this->getFirstMediaUrl('gif') ,
            'likes_count' => $this->likes_count ,
            'comments_count' => $this->comments_count ,
            'liked_by_me' => $this->liked_by_me ,
        ];
    }
}
