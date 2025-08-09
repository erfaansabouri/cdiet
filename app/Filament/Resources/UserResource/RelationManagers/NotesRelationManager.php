<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NotesRelationManager extends RelationManager {
    protected static string  $relationship = 'notes';
    protected static ?string $title        = 'یادداشت های کاربر';

    public function form ( Form $form ): Form {
        return $form->schema([
                                 Forms\Components\TextInput::make('body')
                                                           ->translateLabel()
                                                           ->required() ,
                             ]);
    }

    public function table ( Table $table ): Table {
        return $table->modelLabel(__('Note'))
                     ->heading(__('Notes'))->columns([
                                   Tables\Columns\TextColumn::make('body')
                                                            ->translateLabel() ,
                               ])
                     ->filters([//
                               ])
                     ->headerActions([])
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
