<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Filament\Resources\SettingResource\RelationManagers;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SettingResource extends Resource {
    protected static ?string $model = Setting::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'تنظیمات';

    public static function form ( Form $form ): Form {
        return $form->schema([
                                 Forms\Components\TextInput::make('bazaar_access_token')
                                                           ->label("اکسس توکن بازار")
                                                           ->required(),
                             ]);
    }

    public static function table ( Table $table ): Table {
        return $table->columns([
            Tables\Columns\TextColumn::make('bazaar_access_token')
                ->label("اکسس توکن بازار")
                               ])
                     ->filters([//
                               ])
                     ->actions([
                                   Tables\Actions\EditAction::make() ,
                               ])
                     ->bulkActions([]);
    }

    public static function getRelations (): array {
        return [//
        ];
    }

    public static function getPages (): array {
        return [
            'index' => Pages\ListSettings::route('/') ,
            'create' => Pages\CreateSetting::route('/create') ,
            'edit' => Pages\EditSetting::route('/{record}/edit') ,
        ];
    }

    public static function getLabel (): ?string {
        return __('Setting');
    }

    public static function getPluralLabel (): string {
        return __('Settings');
    }
}
