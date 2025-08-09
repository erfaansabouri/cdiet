<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DietCategoryResource\Pages;
use App\Filament\Resources\DietCategoryResource\RelationManagers;
use App\Models\DietCategory;
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

class DietCategoryResource extends Resource {
    protected static ?string $model          = DietCategory::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "بخش برنامه های غذایی";

    public static function form ( Form $form ): Form {
        return $form->schema([
                                 TextInput::make('title')
                                          ->translateLabel()
                                          ->required()
                                          ->columnSpan(2) ,
                                 SpatieMediaLibraryFileUpload::make('image')
                                                             ->collection('image')
                                                             ->translateLabel()
                                     ->previewable(true)
                                     ->openable()
                                     ->downloadable()
                                                             ->required()
                                                             ->columnSpan(2) ,
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
                                   ])->defaultSort('id', 'desc');
    }

    public static function getRelations (): array {
        return [//
        ];
    }

    public static function getPages (): array {
        return [
            'index' => Pages\ListDietCategories::route('/') ,
            'create' => Pages\CreateDietCategory::route('/create') ,
            'edit' => Pages\EditDietCategory::route('/{record}/edit') ,
        ];
    }

    public static function getLabel (): ?string {
        return __('Diet category');
    }

    public static function getPluralLabel (): string {
        return __('Diet categories');
    }
}
