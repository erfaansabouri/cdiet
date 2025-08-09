<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MealtimeWeekdayResource extends JsonResource {
    public function toArray ( Request $request ): array {
        return [
            'id' => $this->id ,
            'title' => $this->title ,
            'subtitle' => $this->subtitle ,
            'calorie' => $this->calorie ,
            'description' => $this->description ,
            'image_url' => $this->getFirstMediaUrl('image') ,
        ];
    }
}
