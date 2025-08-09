<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource {
    public function toArray ( Request $request ): array {
        return [
            'id' => $this->id ,
            'code' => $this->code ,
            'title' => $this->title ,
            'ticket_status' => TicketStatusResource::make($this->ticketStatus) ,
            'ticket_category' => TicketCategoryResource::make($this->ticketCategory) ,
            'created_at' => Carbon::parse($this->created_at)->timestamp ,
        ];
    }
}
