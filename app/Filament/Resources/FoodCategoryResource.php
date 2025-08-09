<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FoodCategoryResource\Pages;
use App\Filament\Resources\FoodCategoryResource\RelationManagers;
use App\Models\FoodCategory;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FoodCategoryResource extends Resource
{
    protected static ?string $model = FoodCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "بخش خوراکی ها";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                         TextInput::make('title')
                                  ->translateLabel()
                                  ->required()
                                  ->columnSpan(2) ,
                         SpatieMediaLibraryFileUpload::make('image')
                                                     ->collection('image')
                                                     ->translateLabel()
                                                     ->required()
                             ->previewable(true)
                             ->openable()
                             ->downloadable()
                                                     ->columnSpan(2) ,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                          TextColumn::make('id')
                                    ->translateLabel() ,
                          TextColumn::make('title')
                                    ->translateLabel() ,
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->defaultSort('id', 'desc');
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
            'index' => Pages\ListFoodCategories::route('/'),
            'create' => Pages\CreateFoodCategory::route('/create'),
            'edit' => Pages\EditFoodCategory::route('/{record}/edit'),
        ];
    }

    public static function getLabel (): ?string {
        return __('Food category');
    }

    public static function getPluralLabel (): string {
        return __('Food categories');
    }
}
