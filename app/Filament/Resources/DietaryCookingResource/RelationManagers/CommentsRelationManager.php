<?php

namespace App\Filament\Resources\DietaryCookingResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CommentsRelationManager extends RelationManager {
    protected static string $relationship = 'comments';

    public function form ( Form $form ): Form {
        return $form->schema([
                                 Forms\Components\Textarea::make('text')
                                                          ->required()
                                                          ->translateLabel(),
                             ]);
    }

    public function table ( Table $table ): Table {
        return $table->modelLabel(__('Comment'))
                     ->heading(__('Comments'))
                     ->columns([
                                   TextColumn::make('user.full_name')
                                             ->translateLabel() ,
                                   TextColumn::make('text')
                                             ->translateLabel() ,
                                   Tables\Columns\ToggleColumn::make('verified')
                                   ->translateLabel(),
                               ])
                     ->filters([//
                               ])
                     ->headerActions([

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
