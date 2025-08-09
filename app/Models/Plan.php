<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model {
    protected $casts = [
        'is_colorful' => 'boolean' ,
    ];

    public function scopeThroughGateway ( $query , $gateway , $gateway_plan_id ) {
        return $query->where($gateway . "_plan_id" , $gateway_plan_id);
    }
}
