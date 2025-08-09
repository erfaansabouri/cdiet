<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class TicketReplyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'ticket_id' => $this->ticket_id,
            $this->mergeWhen($this->user_id, function () {
                return ['user' => UserResource::make($this->user)];
            }),
            $this->mergeWhen($this->admin_id, function () {
                return ['admin' => AdminResource::make($this->admin)];
            }),
            'description' => $this->description,
            $this->mergeWhen($this->hasMedia('file'), function () {
                return ['file_url' => $this->getFirstMediaUrl('file')];
            }),
            'created_at' => Carbon::parse($this->created_at)->timestamp,
        ];
    }
}
