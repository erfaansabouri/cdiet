<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FoodResource extends JsonResource {
    public function toArray ( Request $request ): array {
        return [
            'id' => $this->id ,
            'title' => $this->title ,
            'calorie' => $this->calorie ,
            'carbohydrate' => $this->carbohydrate ,
            'fat' => $this->fat ,
            'protein' => $this->protein ,
            'image_url' => $this->getFirstMediaUrl('image') ,
        ];
    }
}
