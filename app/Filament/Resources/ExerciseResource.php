<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExerciseResource\Pages;
use App\Filament\Resources\ExerciseResource\RelationManagers;
use App\Models\Exercise;
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
use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class ExerciseResource extends Resource {
    protected static ?string $model           = Exercise::class;
    protected static ?string $navigationIcon  = 'heroicon-o-list-bullet';
    protected static ?string $navigationGroup = "بخش برنامه های ورزشی";

    public static function form ( Form $form ): Form {
        return $form->schema([
                                 TextInput::make('title')
                                          ->translateLabel()
                                          ->required() ,
                                 TextInput::make('calorie')
                                          ->numeric()
                                          ->translateLabel()
                                          ->required() ,
                                 Select::make('exercise_category_id')
                                       ->required()
                                       ->translateLabel()
                                       ->relationship(name: 'exerciseCategory' , titleAttribute: 'title') ,
                                 Forms\Components\Textarea::make('summary')
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
                                 SpatieMediaLibraryFileUpload::make('video')
                                                             ->translateLabel()
                                                             ->previewable(true)
                                                             ->openable()
                                                             ->downloadable()
                                                             ->collection('video') ,
                                 SpatieMediaLibraryFileUpload::make('gif')
                                                             ->translateLabel()
                                                             ->previewable(true)
                                                             ->openable()
                                                             ->downloadable()
                                                             ->collection('gif') ,
                             ]);
    }

    public static function table ( Table $table ): Table {
        return $table->columns([
                                   TextColumn::make('id')
                                             ->translateLabel() ,
                                   TextColumn::make('title')
                                             ->translateLabel() ,
                                   TextColumn::make('exerciseCategory.title')
                                             ->badge()
                                             ->translateLabel() ,
                                   TextColumn::make('calorie')
                                             ->numeric()
                                             ->translateLabel() ,
                               ])
                     ->filters([//
                               ])
                     ->actions([
                                   Tables\Actions\EditAction::make() ,
                               ])
                     ->bulkActions([])
                     ->defaultSort('id' , 'desc');
    }

    public static function getRelations (): array {
        return [
            RelationManagers\CommentsRelationManager::class
        ];
    }

    public static function getPages (): array {
        return [
            'index' => Pages\ListExercises::route('/') ,
            'create' => Pages\CreateExercise::route('/create') ,
            'edit' => Pages\EditExercise::route('/{record}/edit') ,
        ];
    }

    public static function getLabel (): ?string {
        return __('Exercise');
    }

    public static function getPluralLabel (): string {
        return __('Exercises');
    }
}
