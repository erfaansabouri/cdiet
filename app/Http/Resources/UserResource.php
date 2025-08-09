<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

/* @mixin \App\Models\User */
class UserResource extends JsonResource {
    public function toArray ( Request $request ): array {
        return [
            'id' => $this->id ,
            'is_premium' => $this->is_premium ,
            'premium_days_left' => $this->premium_days_left ,
            'last_plan' => PlanResource::make($this->lastPlan()) ,
            'avatar_url' => $this->getFirstMediaUrl('avatar') ,
            'full_name' => $this->full_name ,
            'email' => $this->email ,
            'phone_number' => $this->phone_number ,
            'sex' => $this->sex ,
            'pregnant_status' => $this->pregnant_status ,
            'lactation_status' => $this->lactation_status ,
            'birthday' => $this->birthday ,
            'exercise' => $this->exercise ,
            'height' => $this->height ,
            'weight' => $this->weight ,
            'target_weight' => $this->target_weight ,
            'goal' => $this->goal ,
            'register_completed' => $this->register_completed ,
            'allow_notification' => $this->allow_notification ,
            'created_at' => Carbon::parse($this->created_at)->timestamp ,
        ];
    }
}
