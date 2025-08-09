<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlanResource\Pages;
use App\Filament\Resources\PlanResource\RelationManagers;
use App\Models\Plan;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PlanResource extends Resource {
    protected static ?string $model           = Plan::class;
    protected static ?string $navigationIcon  = 'heroicon-o-cube';
    protected static ?string $navigationGroup = 'بخش مالی';

    public static function form ( Form $form ): Form {
        return $form->schema([
                                 TextInput::make('myket_plan_id')
                                          ->translateLabel()
                                          ->required() ,
                                 TextInput::make('bazaar_plan_id')
                                          ->translateLabel()
                                          ->required() ,
                                 TextInput::make('days')
                                          ->numeric()
                                          ->translateLabel()
                                          ->required() ,
                                 TextInput::make('text_1')
                                          ->translateLabel()
                                          ->required() ,
                                 TextInput::make('text_2')
                                          ->translateLabel()
                                          ->required() ,
                                 TextInput::make('text_3')
                                          ->translateLabel()
                                          ->required() ,
                                 Forms\Components\Toggle::make('is_colorful')
                                                            ->translateLabel() ,
                             ]);
    }

    public static function table ( Table $table ): Table {
        return $table->columns([
                                   TextColumn::make('id')
                                             ->translateLabel() ,
                                   TextColumn::make('myket_plan_id')
                                             ->translateLabel() ,
                                   TextColumn::make('bazaar_plan_id')
                                             ->translateLabel() ,
                                   TextColumn::make('days')
                                             ->numeric()
                                             ->translateLabel() ,
                                   TextColumn::make('text_1')
                                             ->translateLabel() ,
                                   TextColumn::make('text_2')
                                             ->translateLabel() ,
                                   TextColumn::make('text_3')
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
                                   ])
                     ->defaultSort('id' , 'desc');
    }

    public static function getRelations (): array {
        return [//
        ];
    }

    public static function getPages (): array {
        return [
            'index' => Pages\ListPlans::route('/') ,
            'create' => Pages\CreatePlan::route('/create') ,
            'edit' => Pages\EditPlan::route('/{record}/edit') ,
        ];
    }

    public static function getLabel (): ?string {
        return __('Plan');
    }

    public static function getPluralLabel (): string {
        return __('Plans');
    }
}
