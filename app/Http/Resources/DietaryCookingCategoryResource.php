<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DietaryCookingCategoryResource extends JsonResource {
    public function toArray ( Request $request ): array {
        return [
            'id' => $this->id ,
            'title' => $this->title ,
            'image_url' => $this->getFirstMediaUrl('image') ,
            'dietary_cookings_count' => $this->dietary_cookings_count ,
        ];
    }
}
