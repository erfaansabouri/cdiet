<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TextResource\Pages;
use App\Filament\Resources\TextResource\RelationManagers;
use App\Models\Text;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TextResource extends Resource {
    protected static ?string $model = Text::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form ( Form $form ): Form {
        return $form->schema([
                                 Forms\Components\TextInput::make('key')
                                                           ->required()
                                                           ->translateLabel() ,
                                 Forms\Components\TextInput::make('value')
                                                           ->required()
                                                           ->translateLabel() ,
                             ]);
    }

    public static function table ( Table $table ): Table {
        return $table->columns([
            Tables\Columns\TextColumn::make('key')
            ->translateLabel(),
            Tables\Columns\TextColumn::make('value')
                                     ->translateLabel(),
                               ])
                     ->filters([//
                               ])
                     ->actions([
                                   Tables\Actions\EditAction::make() ,
                               ])
                     ->bulkActions([

                                   ]);
    }

    public static function getRelations (): array {
        return [//
        ];
    }

    public static function getPages (): array {
        return [
            'index' => Pages\ListTexts::route('/') ,
            'create' => Pages\CreateText::route('/create') ,
            'edit' => Pages\EditText::route('/{record}/edit') ,
        ];
    }

    public static function getLabel (): ?string {
        return __('Text');
    }

    public static function getPluralLabel (): string {
        return __('Texts');
    }
}
