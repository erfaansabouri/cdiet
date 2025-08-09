<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TermResource extends JsonResource {
    public function toArray ( Request $request ): array {
        return [
            'title' => $this->title ,
            'summary' => $this->summary ,
            'body' => $this->body ,
        ];
    }
}
