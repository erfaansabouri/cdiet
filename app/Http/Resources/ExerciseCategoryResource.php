<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExerciseCategoryResource extends JsonResource {
    public function toArray ( Request $request ): array {
        return [
            'id' => $this->id ,
            'title' => $this->title ,
            'premium' => $this->premium ,
            'image_url' => $this->getFirstMediaUrl('image') ,
            'exercises_count' => $this->exercises_count ,
        ];
    }
}
