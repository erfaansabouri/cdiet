<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasUniqueCode
{
    public static function bootHasUniqueCode()
    {
        static::creating(function ($model) {
            $model->code = self::generateCode();
        });
    }

    public static function generateCode()
    {
        $code = strtoupper(Str::random(8));
        if (self::where('code', $code)
            ->exists()) {
            return self::generateCode();
        }

        return $code;
    }
}
