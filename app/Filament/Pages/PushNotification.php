<?php

namespace App\Filament\Pages;

use App\Models\User;
use Exception;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Exceptions\Halt;
use Kreait\Firebase\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;
use Livewire\WithFileUploads;

class PushNotification extends Page implements HasForms {
    use InteractsWithForms , WithFileUploads;

    public ?array            $data                          = [];
    public string            $push_notification_title       = '';
    public string            $push_notification_description = '';
    protected static ?string $navigationIcon                = 'heroicon-o-bell-alert';
    protected static string  $view                          = 'filament.pages.push-notification';
    protected static ?string $navigationLabel               = 'ارسال پوش نوتیفیکشن';
    protected static ?string $title                         = 'ارسال پوش نوتیفیکشن';

    public static function shouldRegisterNavigation (): bool {
        return true;
    }

    public function form ( Form $form ): Form {
        return $form->schema([
                                 TextInput::make('push_notification_title')
                                          ->label('عنوان')
                                          ->required() ,
                                 TextInput::make('push_notification_description')
                                          ->label('توضیحات')
                                          ->required() ,
                             ]);
    }

    protected function getFormActions (): array {
        return [
            Action::make('send')
                  ->label('ارسال')
                  ->submit('send') ,
        ];
    }

    public function send (): void {
        try {
            $data = $this->form->getState();
            $push_notification_title = $data[ 'push_notification_title' ];
            $push_notification_description = $data[ 'push_notification_description' ];
            $users = User::query()
                         ->whereNotNull('firebase_token')
                         ->get();
            $data = [
                'custom_title' => $push_notification_title ,
                'custom_description' => $push_notification_description ,
                'click_action' => 'android.intent.action.VIEW' ,
                'action_data' => 'https://caloriediet.ir/fcm' ,
                'image' => asset('logo.jpg') ,
            ];
            $messaging = app('firebase.messaging');
            foreach ( $users as $user ) {
                try {
                    $message = CloudMessage::withTarget('token' , $user->firebase_token)
                                           ->withNotification(Messaging\Notification::create($push_notification_title , $push_notification_description , asset('logo.jpg')))
                                           ->withData($data);
                    $messaging->send($message);
                }
                catch ( Exception $exception ) {

                }
            }
            Notification::make()
                        ->success()
                        ->title('پیام با موفقیت برای کاربران ارسال گردید.')
                        ->send();
        }
        catch ( Halt $exception ) {
            return;
        }
    }
}
