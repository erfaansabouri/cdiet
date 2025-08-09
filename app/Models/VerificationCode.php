<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Model {
    public static function inCoolDown ( $value ) {
        $last_record = self::query()
                           ->where('phone_number' , $value)
                           ->orWhere('email' , $value)
                           ->latest()
                           ->first();
        if ( $last_record && Carbon::parse($last_record->created_at)
                                   ->diffInMinutes(now()) < 2 ) {
            return true;
        }

        return false;
    }

    public function scopeNotUsed ( $query ) {
        return $query->whereNull('used_at');
    }
}
