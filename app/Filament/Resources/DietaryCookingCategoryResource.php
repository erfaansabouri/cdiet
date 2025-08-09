<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DietaryCookingCategoryResource\Pages;
use App\Filament\Resources\DietaryCookingCategoryResource\RelationManagers;
use App\Models\DietaryCookingCategory;
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

class DietaryCookingCategoryResource extends Resource {
    protected static ?string $model           = DietaryCookingCategory::class;
    protected static ?string $navigationIcon  = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "بخش آشپزی رژیمی";

    public static function form ( Form $form ): Form {
        return $form->schema([
                                 TextInput::make('title')
                                          ->translateLabel()
                                          ->required()
                                          ->columnSpan(2) ,
                                 SpatieMediaLibraryFileUpload::make('image')
                                                             ->collection('image')
                                     ->previewable(true)
                                     ->openable()
                                     ->downloadable()
                                                             ->translateLabel()
                                                             ->required()
                                                             ->columnSpan(2) ,
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
            'index' => Pages\ListDietaryCookingCategories::route('/') ,
            'create' => Pages\CreateDietaryCookingCategory::route('/create') ,
            'edit' => Pages\EditDietaryCookingCategory::route('/{record}/edit') ,
        ];
    }

    public static function getLabel (): ?string {
        return __('Dietary cooking category');
    }

    public static function getPluralLabel (): string {
        return __('Dietary cooking categories');
    }
}
