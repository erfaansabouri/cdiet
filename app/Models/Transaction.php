<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model {
    public function user (): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function plan (): BelongsTo {
        return $this->belongsTo(Plan::class);
    }

    const GATEWAYS = [
        'myket' => 'myket' ,
        'bazaar' => 'bazaar' ,
    ];
}
