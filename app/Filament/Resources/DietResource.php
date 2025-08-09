<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DietResource\Pages;
use App\Filament\Resources\DietResource\RelationManagers;
use App\Models\Diet;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class DietResource extends Resource {
    protected static ?string $model = Diet::class;
    protected static ?string $navigationIcon  = 'heroicon-o-list-bullet';
    protected static ?string $navigationGroup = "بخش برنامه های غذایی";

    public static function form ( Form $form ): Form {
        return $form->schema([
                                 Select::make('diet_category_id')
                                       ->required()
                                       ->translateLabel()
                                       ->relationship(name: 'dietCategory' , titleAttribute: 'title') ,
                                 TextInput::make('title')
                                          ->translateLabel()
                                          ->required() ,
                                 TinyEditor::make('description')
                                           ->translateLabel()
                                           ->required() ,
                                 SpatieMediaLibraryFileUpload::make('image')
                                                             ->translateLabel()
                                     ->previewable(true)
                                     ->openable()
                                     ->downloadable()
                                                             ->collection('image')
                                                             ->image() ,
                             ]);
    }

    public static function table ( Table $table ): Table {
        return $table->columns([
                                   TextColumn::make('id')
                                             ->translateLabel() ,
                                   TextColumn::make('title')
                                             ->translateLabel() ,
                                   TextColumn::make('dietCategory.title')
                                             ->badge()
                                             ->translateLabel() ,
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
                                   ])->defaultSort('id', 'desc');
    }

    public static function getRelations (): array {
        return [//
        ];
    }

    public static function getPages (): array {
        return [
            'index' => Pages\ListDiets::route('/') ,
            'create' => Pages\CreateDiet::route('/create') ,
            'edit' => Pages\EditDiet::route('/{record}/edit') ,
        ];
    }

    public static function getLabel (): ?string {
        return __('Diet');
    }

    public static function getPluralLabel (): string {
        return __('Diets');
    }
}
