<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AiSettingResource\Pages;
use App\Filament\Resources\AiSettingResource\RelationManagers;
use App\Models\AiSetting;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AiSettingResource extends Resource
{
    protected static ?string $model = AiSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                         Forms\Components\Textarea::make('system_content')
                                  ->label('پرامپت شخصی سازی')
                                  ->required()
                                  ->columnSpan(2) ,
                         Forms\Components\Textarea::class::make('max_completion_tokens')
                                                  ->label('حداکثر توکن مصرفی به ازای هر پیام')
                                                  ->required()
                                                  ->columnSpan(2) ,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAiSettings::route('/'),
            'create' => Pages\CreateAiSetting::route('/create'),
            'edit' => Pages\EditAiSetting::route('/{record}/edit'),
        ];
    }

    public static function getLabel (): ?string {
        return __('Ai setting');
    }

    public static function getPluralLabel (): string {
        return __('Ai settings');
    }
}
