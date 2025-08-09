<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionResource extends Resource {
    protected static ?string $model           = Transaction::class;
    protected static ?string $navigationIcon  = 'heroicon-o-currency-dollar';
    protected static ?string $navigationGroup = 'بخش مالی';

    public static function form ( Form $form ): Form {
        return $form->schema([//
                             ]);
    }

    public static function table ( Table $table ): Table {
        return $table->columns([
                                   TextColumn::make('id')
                                             ->translateLabel() ,
                                   TextColumn::make('token')
                                             ->translateLabel()
                                             ->badge() ,
                                   TextColumn::make('gateway')
                                             ->translateLabel()
                                             ->badge() ,
                                   TextColumn::make('user.full_name')
                                             ->description(fn ( Transaction $record ): ?string => $record->user->phone_number)
                                             ->translateLabel() ,
                                   TextColumn::make('plan.text_2')
                                             ->translateLabel() ,
                                   TextColumn::make('verified_at')
                                             ->translateLabel()
                                             ->jalaliDateTime() ,
                               ])
                     ->filters([//
                               ])
                     ->actions([
                                   //Tables\Actions\ViewAction::make() ,
                               ])
                     ->bulkActions([])->defaultSort('id', 'desc');
    }

    public static function getRelations (): array {
        return [//
        ];
    }

    public static function getPages (): array {
        return [
            'index' => Pages\ListTransactions::route('/') ,
        ];
    }

    public static function getLabel (): ?string {
        return __('Transaction');
    }

    public static function getPluralLabel (): string {
        return __('Transactions');
    }
}
