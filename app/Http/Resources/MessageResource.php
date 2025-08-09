<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/* @mixin \App\Models\Message */
class MessageResource extends JsonResource {
    public function toArray ( Request $request ): array {
        return [
            'id' => $this->id ,
            'content' => $this->content ,
            'role' => $this->role ,
            'created_at' => Carbon::parse($this->created_at)->timestamp,
        ];
    }
}
