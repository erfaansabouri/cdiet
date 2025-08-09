<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FoodUnitResource\Pages;
use App\Filament\Resources\FoodUnitResource\RelationManagers;
use App\Models\FoodUnit;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class FoodUnitResource extends Resource {
    protected static ?string $model          = FoodUnit::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "بخش خوراکی ها";

    public static function form ( Form $form ): Form {
        return $form->schema([
                                 TextInput::make('title')
                                          ->translateLabel()
                                          ->required() ,
                                 RichEditor::make('description')
                                           ->translateLabel()
                                           ->required() ,
                                 TinyEditor::make('description')
                                           ->translateLabel()
                                           ->required() ,
                                 SpatieMediaLibraryFileUpload::make('image')
                                                             ->collection('image')
                                     ->previewable(true)
                                     ->openable()
                                     ->downloadable()
                                                             ->translateLabel()
                                                             ->required() ,
                             ]);
    }

    public static function table ( Table $table ): Table {
        return $table->columns([
                                   TextColumn::make('id')
                                             ->translateLabel()
                                             ->searchable() ,
                                   TextColumn::make('title')
                                             ->translateLabel()
                                             ->searchable() ,
                               ])
                     ->filters([//
                               ])
                     ->actions([
                                   Tables\Actions\EditAction::make() ,
                               ])
                     ->bulkActions([
                                       Tables\Actions\BulkActionGroup::make([
                                                                                Tables\Actions\DeleteBulkAction::make() ,
                                                                            ]) ,
                                   ])
                     ->emptyStateActions([
                                             Tables\Actions\CreateAction::make() ,
                                         ])->defaultSort('id', 'desc');
    }

    public static function getRelations (): array {
        return [//
        ];
    }

    public static function getPages (): array {
        return [
            'index' => Pages\ListFoodUnits::route('/') ,
            'create' => Pages\CreateFoodUnit::route('/create') ,
            'edit' => Pages\EditFoodUnit::route('/{record}/edit') ,
        ];
    }

    public static function getLabel (): ?string {
        return __('Food unit');
    }

    public static function getPluralLabel (): string {
        return __('Food units');
    }
}
