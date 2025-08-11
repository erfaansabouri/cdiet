<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MealtimeResource\Pages;
use App\Filament\Resources\MealtimeResource\RelationManagers;
use App\Filament\Resources\MealtimeResource\RelationManagers\MealtimeWeekdayRelationManager;
use App\Models\Mealtime;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MealtimeResource extends Resource {
    protected static ?string $model           = Mealtime::class;
    protected static ?string $navigationIcon  = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "بخش خوراکی ها ورژن جدید";

    public static function form ( Form $form ): Form {
        return $form->schema([
                                 Forms\Components\Fieldset::make('گروه')
                                                          ->schema([
                                                                       Select::make('group')
                                                                             ->options([
                                                                                           'کاهش وزن' => 'کاهش وزن' ,
                                                                                           'افزایش وزن' => 'افزایش وزن' ,
                                                                                           'تثبیت وزن' => 'تثبیت وزن' ,
                                                                                       ])
                                                                             ->label('گروه') ,
                                                                       Forms\Components\Toggle::make('for_pregnant')
                                                                                              ->label('مخصوص باردار ها') ,
                                                                       Forms\Components\Toggle::make('for_lactation')
                                                                                              ->label('مخصوص زنان شیر ده') ,
                                                                   ]) ,
                                 Forms\Components\Fieldset::make('تعیین گروه اضافه وزن مناسب با این وعده')
                                                          ->schema([
                                                                       TextInput::make('from')
                                                                                ->label("میزان اضافه وزن از")
                                                                                ->numeric()
                                                                                ->columnSpan(2) ,
                                                                       TextInput::make('to')
                                                                                ->label("میزان اضافه وزن تا")
                                                                                ->numeric()
                                                                                ->columnSpan(2) ,
                                                                   ]) ,
                                 Forms\Components\Fieldset::make('تعیین گروه کمبود وزن مناسب با این وعده')
                                                          ->schema([
                                                                       TextInput::make('from2')
                                                                                ->label("میزان کمبود وزن از")
                                                                                ->numeric()
                                                                                ->columnSpan(2) ,
                                                                       TextInput::make('to2')
                                                                                ->label("میزان کمبود وزن تا")
                                                                                ->numeric()
                                                                                ->columnSpan(2) ,
                                                                   ]) ,
                                 TextInput::make('calorie')
                                          ->translateLabel()
                                          ->required()
                                          ->numeric()
                                          ->columnSpan(2) ,
                                 TextInput::make('title')
                                          ->translateLabel()
                                          ->required()
                                          ->columnSpan(2) ,
                                 TextInput::make('subtitle')
                                          ->translateLabel()
                                          ->required()
                                          ->columnSpan(2) ,
                                 TextInput::make('hours')
                                          ->translateLabel()
                                          ->required()
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

    public static function table ( Table $table ): Table {
        return $table->columns([
                                   TextColumn::make('id')
                                             ->translateLabel() ,
                                   TextColumn::make('title')
                                             ->translateLabel() ,
                                   TextColumn::make('group')
                                             ->label('گروه') ,
                               ])
                     ->filters([
                                   SelectFilter::make('group')
                                               ->label('گروه')
                                               ->options([
                                                             'کاهش وزن' => 'کاهش وزن' ,
                                                             'افزایش وزن' => 'افزایش وزن' ,
                                                             'تثبیت وزن' => 'تثبیت وزن' ,
                                                         ]),
                               ])
                     ->actions([
                                   Tables\Actions\EditAction::make() ,
                               ])
                     ->bulkActions([
                                       Tables\Actions\BulkActionGroup::make([
                                                                                Tables\Actions\DeleteBulkAction::make() ,
                                                                            ]) ,
                                   ]);
    }

    public static function getRelations (): array {
        return [
            MealtimeWeekdayRelationManager::class ,
        ];
    }

    public static function getPages (): array {
        return [
            'index' => Pages\ListMealtimes::route('/') ,
            'create' => Pages\CreateMealtime::route('/create') ,
            'edit' => Pages\EditMealtime::route('/{record}/edit') ,
        ];
    }

    public static function getLabel (): ?string {
        return "وعده غذایی ورژن جدید";
    }

    public static function getPluralLabel (): string {
        return "وعده های غذایی ورژن جدید";
    }
}
