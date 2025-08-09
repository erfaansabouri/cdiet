<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model {
    const ROLE = [
        'user' => 'user' ,
        'assistant' => 'assistant',
    ];
}
