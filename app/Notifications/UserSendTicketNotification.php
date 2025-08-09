<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class UserSendTicketNotification extends Notification {
    use Queueable;
    public function __construct () {
        //
    }

    public function via ( object $notifiable ): array {
        return [ 'database' ];
    }

    public function toDatabase ( object $notifiable ): array {
        return [
            'title' => 'تیم پشتیبانی' ,
            'description' => 'کاربر عزیز! پیام شما را دریافت کردیم و بزودی به آن پاسخ خواهیم داد.' ,
        ];
    }
}
