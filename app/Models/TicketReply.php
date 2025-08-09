<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class TicketReply extends Model implements HasMedia {
    use InteractsWithMedia;

    public function registerMediaCollections (): void {
        $this->addMediaCollection('file')
             ->singleFile();
    }

    public function ticket (): BelongsTo {
        return $this->belongsTo(Ticket::class);
    }

    public function user (): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function admin (): BelongsTo {
        return $this->belongsTo(Admin::class);
    }
}
