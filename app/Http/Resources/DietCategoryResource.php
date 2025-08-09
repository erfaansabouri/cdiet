<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DietCategoryResource extends JsonResource {
    public function toArray ( Request $request ): array {
        return [
            'id' => $this->id ,
            'title' => $this->title ,
            'image_url' => $this->getFirstMediaUrl('image') ,
            'diets_count' => $this->diets_count ,
        ];
    }
}
