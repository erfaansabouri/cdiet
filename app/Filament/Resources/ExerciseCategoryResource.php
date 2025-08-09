<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExerciseCategoryResource\Pages;
use App\Filament\Resources\ExerciseCategoryResource\RelationManagers;
use App\Models\ExerciseCategory;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExerciseCategoryResource extends Resource {
    protected static ?string $model           = ExerciseCategory::class;
    protected static ?string $navigationIcon  = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "بخش برنامه های ورزشی";

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
                                 Toggle::make('premium')
                                       ->translateLabel()
                                       ->onColor('success')
                                       ->offColor('danger')
                                       ->columnSpan(2) ,
                             ]);
    }

    public static function table ( Table $table ): Table {
        return $table->columns([
                                   TextColumn::make('id')
                                             ->translateLabel() ,
                                   TextColumn::make('title')
                                             ->translateLabel() ,
                                   IconColumn::make('premium')
                                             ->boolean()
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
            'index' => Pages\ListExerciseCategories::route('/') ,
            'create' => Pages\CreateExerciseCategory::route('/create') ,
            'edit' => Pages\EditExerciseCategory::route('/{record}/edit') ,
        ];
    }

    public static function getLabel (): ?string {
        return __('Exercise category');
    }

    public static function getPluralLabel (): string {
        return __('Exercises categories');
    }
}
