<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DietaryCookingResource\Pages;
use App\Filament\Resources\DietaryCookingResource\RelationManagers;
use App\Models\DietaryCooking;
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

class DietaryCookingResource extends Resource {
    protected static ?string $model           = DietaryCooking::class;
    protected static ?string $navigationIcon  = 'heroicon-o-list-bullet';
    protected static ?string $navigationGroup = "بخش آشپزی رژیمی";

    public static function form ( Form $form ): Form {
        return $form->schema([
                                 TextInput::make('title')
                                          ->translateLabel()
                                          ->required() ,
                                 TinyEditor::make('description')
                                           ->translateLabel()
                                           ->required() ,
                                 Select::make('dietary_cooking_category_id')
                                       ->required()
                                       ->translateLabel()
                                       ->relationship(name: 'dietaryCookingCategory' , titleAttribute: 'title') ,
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
                                   TextColumn::make('dietaryCookingCategory.title')
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
        return [
            RelationManagers\CommentsRelationManager::class
        ];
    }

    public static function getPages (): array {
        return [
            'index' => Pages\ListDietaryCookings::route('/') ,
            'create' => Pages\CreateDietaryCooking::route('/create') ,
            'edit' => Pages\EditDietaryCooking::route('/{record}/edit') ,
        ];
    }

    public static function getLabel (): ?string {
        return __('Dietary cooking');
    }

    public static function getPluralLabel (): string {
        return __('Dietary cookings');
    }
}
