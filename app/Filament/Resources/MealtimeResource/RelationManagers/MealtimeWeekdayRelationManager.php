<?php

namespace App\Filament\Resources\MealtimeResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MealtimeWeekdayRelationManager extends RelationManager {
    protected static string  $relationship = 'mealtimeWeekdays';
    protected static ?string $title        = 'روز های هفته';

    public function form ( Form $form ): Form {
        return $form->schema([
                                 TextInput::make('title')
                                          ->translateLabel()
                                          ->required()
                                          ->columnSpan(2) ,
                                 TextInput::make('subtitle')
                                          ->translateLabel()
                                          ->required()
                                          ->columnSpan(2) ,
                                 TextInput::make('calorie')
                                          ->translateLabel()
                                          ->required()
                                          ->numeric()
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
                             ]);
    }

    public function table ( Table $table ): Table {
        return $table->modelLabel("روز های هفته")
                     ->heading("روز های هفته")
                     ->columns([
                                   Tables\Columns\TextColumn::make('title')
                                                            ->translateLabel() ,
                               ])
                     ->filters([//
                               ])
                     ->headerActions([
                                         Tables\Actions\CreateAction::make() ,
                                     ])
                     ->actions([
                                   Tables\Actions\EditAction::make() ,
                                   Tables\Actions\DeleteAction::make() ,
                               ])
                     ->bulkActions([
                                       Tables\Actions\BulkActionGroup::make([
                                                                                Tables\Actions\DeleteBulkAction::make() ,
                                                                            ]) ,
                                   ]);
    }
}
