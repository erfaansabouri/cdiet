<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Ariaieboy\FilamentJalaliDatetimepicker\Forms\Components\JalaliDatePicker;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;

class EditUser extends EditRecord {
    protected static string $resource = UserResource::class;

    public function form ( Form $form ): Form {
        return $form->schema([
                                 TextInput::make('full_name')
                                          ->translateLabel()
                                          ->required()
                                          ->maxLength(255) ,
                                 TextInput::make('email')
                                          ->translateLabel()
                                          ->unique(ignoreRecord: true) ,
                                 TextInput::make('phone_number')
                                          ->translateLabel()
                                          ->unique(ignoreRecord: true) ,
                                 Select::make('sex')
                                       ->translateLabel()
                                       ->required()
                                       ->options(array_combine(User::SEXES , User::SEXES)) ,
                                 Toggle::make('pregnant_status')
                                       ->translateLabel()
                                       ->onColor('success')
                                       ->offColor('danger') ,
                                 Toggle::make('lactation_status')
                                       ->translateLabel()
                                       ->onColor('success')
                                       ->offColor('danger') ,
                                 TextInput::make('birthday')
                                                 ->translateLabel() ,
                                 Select::make('exercise')
                                       ->label(__('User exercise'))
                                       ->required()
                                       ->options(array_combine(User::EXERCISES , User::EXERCISES)) ,
                                 TextInput::make('height')
                                          ->translateLabel() ,
                                 TextInput::make('weight')
                                          ->translateLabel() ,
                                 TextInput::make('target_weight')
                                          ->translateLabel() ,
                                 Select::make('goal')
                                       ->label(__('User goal'))
                                       ->options([
                                                     'افزایش وزن' => 'افزایش وزن' ,
                                                     'کاهش وزن' => 'کاهش وزن' ,
                                                     'تثبیت وزن' => 'تثبیت وزن' ,
                                                     null => 'وزن دلخواه' ,
                                                 ]) ,
                                 JalaliDatePicker::make('premium_expires_at')
                                                 ->jalali()
                                                 ->translateLabel()
                                                 ->displayFormat('Y/m/d') ,
                                 Toggle::make('disable')
                                       ->label('غیر فعال کردن')
                                       ->onColor('danger'),
                             ]);
    }

    protected function getHeaderActions (): array {
        return [];
    }
}
