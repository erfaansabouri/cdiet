<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model {
    protected static function boot () {
        parent::boot();
        static::saved(function ( Setting $setting ) {
            $setting->bazaar_access_token_updated_at = now();
            $setting->saveQuietly();
        });
    }
}
