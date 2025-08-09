<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TermResource\Pages;
use App\Filament\Resources\TermResource\RelationManagers;
use App\Models\Term;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class TermResource extends Resource {
    protected static ?string $model          = Term::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form ( Form $form ): Form {
        return $form->schema([
                                 TextInput::make('title')
                                          ->translateLabel()
                                          ->required()->columnSpan(2) ,

                                 TinyEditor::make('summary')
                                           ->translateLabel()
                                           ->required() ,
                                 TinyEditor::make('body')
                                           ->translateLabel()
                                           ->required() ,
                             ]);
    }

    public static function table ( Table $table ): Table {
        return $table->columns([
                                   TextColumn::make('id')
                                             ->translateLabel() ,
                                   TextColumn::make('title')
                                             ->translateLabel() ,
                               ])
                     ->filters([//
                               ])
                     ->actions([
                                   Tables\Actions\EditAction::make() ,
                               ])
                     ->bulkActions([])
                     ->emptyStateActions([])->defaultSort('id', 'desc');
    }

    public static function getRelations (): array {
        return [//
        ];
    }

    public static function getPages (): array {
        return [
            'index' => Pages\ListTerms::route('/') ,
            'edit' => Pages\EditTerm::route('/{record}/edit') ,
        ];
    }

    public static function getLabel (): ?string {
        return __('Term');
    }

    public static function getPluralLabel (): string {
        return __('Terms');
    }
}
