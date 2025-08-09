<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource {
    public function toArray ( Request $request ): array {
        return [
            'id' => $this->id ,
            'myket_plan_id' => $this->myket_plan_id ,
            'bazaar_plan_id' => $this->bazaar_plan_id ,
            'text_1' => $this->text_1 ,
            'text_2' => $this->text_2 ,
            'text_3' => $this->text_3 ,
            'is_colorful' => $this->is_colorful ,
        ];
    }
}
