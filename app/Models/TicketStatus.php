<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketStatus extends Model {
    const PENDING  = 1;
    const ANSWERED = 2;
    const CLOSED   = 3;
}
