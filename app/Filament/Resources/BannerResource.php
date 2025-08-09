<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Filament\Resources\BannerResource\RelationManagers;
use App\Models\Banner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BannerResource extends Resource {
    protected static ?string $model          = Banner::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form ( Form $form ): Form {
        return $form->schema([
                                 Forms\Components\TextInput::make('title')
                                                           ->translateLabel() ,
                                 Forms\Components\Select::make('location')
                                                        ->translateLabel()
                                                        ->required()
                                                        ->options([
                                                                      'home' => 'صفحه اصلی' ,
                                                                      'calorie-counter' => 'صفحه کالری شمار' ,
                                                                  ]) ,
                                 Forms\Components\Select::make('target')
                                                        ->translateLabel()
                                                        ->required()
                                                        ->options([
                                                                      'exercise-categories' => 'صفحه دسته بندی های برنامه ورزشی' ,
                                                                  ]) ,
                                 Forms\Components\SpatieMediaLibraryFileUpload::make('image')
                                                                              ->collection('image')
                                                                              ->translateLabel()
                                                                              ->required()
                                                                              ->columnSpan(2)
                                                                              ->previewable(true)
                                                                              ->openable()
                                                                              ->downloadable() ,
                             ]);
    }

    public static function table ( Table $table ): Table {
        return $table->columns([
                                   Tables\Columns\TextColumn::make('title')
                                                            ->translateLabel() ,
                                   Tables\Columns\TextColumn::make('location')
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
                                   ]);
    }

    public static function getRelations (): array {
        return [//
        ];
    }

    public static function getPages (): array {
        return [
            'index' => Pages\ListBanners::route('/') ,
            'create' => Pages\CreateBanner::route('/create') ,
            'edit' => Pages\EditBanner::route('/{record}/edit') ,
        ];
    }

    public static function getLabel (): ?string {
        return __('Banner');
    }

    public static function getPluralLabel (): string {
        return __('Banners');
    }
}
