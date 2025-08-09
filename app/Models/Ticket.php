<?php

namespace App\Models;

use App\Traits\HasUniqueCode;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model {
    use HasUniqueCode;

    protected static function boot () {
        parent::boot();
        static::creating(function ( $ticket ) {
            $ticket->ticket_status_id = TicketStatus::PENDING;
        });
    }

    public function ticketReplies (): HasMany {
        return $this->hasMany(TicketReply::class);
    }

    public function ticketCategory (): BelongsTo {
        return $this->belongsTo(TicketCategory::class);
    }

    public function ticketStatus (): BelongsTo {
        return $this->belongsTo(TicketStatus::class);
    }

    public function user (): BelongsTo {
        return $this->belongsTo(User::class);
    }

    protected function lastUserTicketReply (): Attribute {
        return Attribute::make(get: fn () => $this->ticketReplies()
                                                  ->whereNotNull('user_id')
                                                  ->latest()
                                                  ->first());
    }
}
