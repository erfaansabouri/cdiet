<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource {
    public function toArray ( Request $request ): array {
        return [
            'id' => $this->id ,
            'created_at' => Carbon::parse($this->created_at)->timestamp ,
            'read_at' => $this->read_at ? Carbon::parse($this->read_at)->timestamp : null ,
            'title' => $this->data[ 'title' ] ,
            'description' => $this->data[ 'description' ] ,
            'question' => @$this->data[ 'question' ] ?? "" ,
        ];
    }
}
