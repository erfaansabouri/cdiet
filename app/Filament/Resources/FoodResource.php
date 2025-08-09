<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FoodResource\Pages;
use App\Filament\Resources\FoodResource\RelationManagers;
use App\Models\Food;
use Filament\Forms;
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

class FoodResource extends Resource {
    protected static ?string $model           = Food::class;
    protected static ?string $navigationIcon  = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "بخش خوراکی ها";

    public static function form ( Form $form ): Form {
        return $form->schema([
                                 TextInput::make('title')
                                          ->translateLabel()
                                          ->required() ,
                                 Select::make('food_category_id')
                                       ->required()
                                       ->translateLabel()
                                       ->relationship(name: 'foodCategory' , titleAttribute: 'title') ,
                                 TextInput::make('calorie')
                                          ->numeric()
                                          ->translateLabel()
                                          ->required() ,
                                 TextInput::make('carbohydrate')
                                          ->numeric()
                                          ->translateLabel()
                                          ->required() ,
                                 TextInput::make('fat')
                                          ->numeric()
                                          ->translateLabel()
                                          ->required() ,
                                 TextInput::make('protein')
                                          ->numeric()
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
                                   TextColumn::make('foodCategory.title')
                                             ->badge()
                                             ->translateLabel() ,
                                   TextColumn::make('calorie')
                                             ->numeric()
                                             ->translateLabel() ,
                                   TextColumn::make('carbohydrate')
                                             ->numeric()
                                             ->translateLabel() ,
                                   TextColumn::make('fat')
                                             ->numeric()
                                             ->translateLabel() ,
                                   TextColumn::make('protein')
                                             ->numeric()
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
            'index' => Pages\ListFood::route('/') ,
            'create' => Pages\CreateFood::route('/create') ,
            'edit' => Pages\EditFood::route('/{record}/edit') ,
        ];
    }

    public static function getLabel (): ?string {
        return __('Food');
    }

    public static function getPluralLabel (): string {
        return __('Foods');
    }
}
