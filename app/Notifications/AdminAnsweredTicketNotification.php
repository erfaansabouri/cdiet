<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;

class AdminAnsweredTicketNotification extends Notification {
    use Queueable;

    private $description;
    private $last_user_ticket_reply;

    public function __construct ( $description , $last_user_ticket_reply ) {
        $this->description = $description;
        $this->last_user_ticket_reply = $last_user_ticket_reply;
    }

    public function via ( object $notifiable ): array {
        $via = [ 'database' ];
        if ( $notifiable->firebase_token ) {
            $via[] = FcmChannel::class;
        }

        return $via;
    }

    public function toFcm ( $notifiable ) {
        return FcmMessage::create()
                         ->setData([
                                       'custom_title' => 'تیم پشتیبانی' ,
                                       'custom_description' => $this->description ,
                                       'custom_question' => $this->last_user_ticket_reply ,
                                       'click_action' => 'android.intent.action.VIEW' ,
                                       'action_data' => 'https://caloriediet.ir/fcm' ,
                                   ])
                         ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
                                                                                           ->setTitle('تیم پشتیبانی')
                                                                                           ->setBody($this->description))
                         ->setAndroid(AndroidConfig::create()
                                                   ->setFcmOptions(AndroidFcmOptions::create()
                                                                                    ->setAnalyticsLabel('analytics'))
                                                   ->setNotification(AndroidNotification::create()
                                                                                        ->setColor('#0A0A0A')))
                         ->setApns(ApnsConfig::create()
                                             ->setFcmOptions(ApnsFcmOptions::create()
                                                                           ->setAnalyticsLabel('analytics_ios')));
    }

    public function toDatabase ( object $notifiable ): array {
        return [
            'title' => 'تیم پشتیبانی' ,
            'description' => $this->description ,
            'question' => $this->last_user_ticket_reply ,
        ];
    }
}
