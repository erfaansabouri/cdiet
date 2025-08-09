<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecommendedMealResource\Pages;
use App\Filament\Resources\RecommendedMealResource\RelationManagers;
use App\Models\RecommendedMeal;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RecommendedMealResource extends Resource {
    protected static ?string $model           = RecommendedMeal::class;
    protected static ?string $navigationIcon  = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "بخش خوراکی ها";

    public static function form ( Form $form ): Form {
        return $form->schema([
                                 TextInput::make('title')
                                          ->translateLabel()
                                          ->required()
                                          ->columnSpan(2) ,
                                 TextInput::make('subtitle')
                                          ->translateLabel()
                                          ->required()
                                          ->columnSpan(2) ,
                                 TextInput::make('hours')
                                          ->translateLabel()
                                          ->required()
                                          ->columnSpan(2) ,
                                 TextInput::make('description')
                                          ->translateLabel()
                                          ->required()
                                          ->columnSpan(2) ,
                                 Forms\Components\SpatieMediaLibraryFileUpload::make('image')
                                                                              ->collection('image')
                                                                              ->translateLabel()
                                                                              ->required()
                                     ->previewable(true)
                                     ->openable()
                                     ->downloadable()
                                                                              ->columnSpan(2) ,
                                 Forms\Components\Select::make('goal')
                                     ->translateLabel()
                                     ->required()
                                     ->options(array_combine(User::GOALS , User::GOALS)) ,

                             ]);
    }

    public static function table ( Table $table ): Table {
        return $table->columns([
                                   TextColumn::make('id')
                                             ->translateLabel() ,
                                   TextColumn::make('title')
                                             ->translateLabel() ,
                                   TextColumn::make('goal')
                                             ->translateLabel() ,
                               ])
                     ->filters([//
                               ])
                     ->actions([
                                   Tables\Actions\EditAction::make() ,
                               ])
                     ->bulkActions([])->defaultSort('id', 'desc');
    }

    public static function getRelations (): array {
        return [//
        ];
    }

    public static function getPages (): array {
        return [
            'index' => Pages\ListRecommendedMeals::route('/') ,
            'edit' => Pages\EditRecommendedMeal::route('/{record}/edit') ,
        ];
    }

    public static function getLabel (): ?string {
        return __('Recommended meal');
    }

    public static function getPluralLabel (): string {
        return __('Recommended meals');
    }
}
