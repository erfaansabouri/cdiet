<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Filament\Resources\TicketResource\RelationManagers;
use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\TicketReply;
use App\Models\TicketStatus;
use App\Notifications\AdminAnsweredTicketNotification;
use App\Notifications\UserSendTicketNotification;
use Exception;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TicketResource extends Resource {
    protected static ?string $model          = Ticket::class;
    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    public static function form ( Form $form ): Form {
        return $form->schema([//
                             ]);
    }

    public static function table ( Table $table ): Table {
        return $table->columns([
                                   TextColumn::make('id')
                                             ->translateLabel() ,
                                   TextColumn::make('code')
                                             ->translateLabel()
                                             ->badge() ,
                                   TextColumn::make('title')
                                             ->limit(50)
                                             ->translateLabel() ,
                                   TextColumn::make('user.full_name')
                                             ->description(fn ( Ticket $record ): ?string => $record->user->phone_number)
                                             ->translateLabel() ,
                                   TextColumn::make('ticketStatus.title')
                                             ->translateLabel()
                                             ->badge()
                                             ->color(fn ( Ticket $record ): string => match ( $record->ticket_status_id ) {
                                                 TicketStatus::PENDING => 'warning' ,
                                                 TicketStatus::ANSWERED => 'success' ,
                                             }) ,
                                   TextColumn::make('ticketCategory.title')
                                             ->translateLabel()
                                             ->badge()
                                             ->color('info') ,
                               ])
                     ->filters([
                                   SelectFilter::make('ticketStatus')
                                               ->translateLabel()
                                               ->relationship('ticketStatus' , 'title') ,
                                   SelectFilter::make('ticketCategory')
                                               ->translateLabel()
                                               ->relationship('ticketCategory' , 'title') ,
                               ])
                     ->actions([
                                   Action::make('answer_a_ticket')
                                         ->button()
                                         ->outlined()
                                         ->icon('heroicon-m-pencil-square')
                                         ->translateLabel()
                                         ->form([
                                                    Placeholder::make('title')
                                                               ->content(fn ( Ticket $record ): string => $record->title)
                                                               ->translateLabel() ,
                                                    Placeholder::make('tarikhche')
                                                               ->label('تاریخچه پاسخ')
                                                               ->content(fn ( Ticket $record ): string => $record->all_replies)
                                                               ->translateLabel() ,
                                                    Forms\Components\Actions::make([
                                                                                       Forms\Components\Actions\Action::make('file')
                                                                                                                      ->translateLabel()
                                                                                                                      ->color('info')
                                                                                                                      ->url(function ( Ticket $record ) {
                                                                                                                          return $record->last_user_ticket_reply->getFirstMediaUrl('file');
                                                                                                                      } , true)
                                                                                                                      ->hidden(function ( Ticket $record ) {
                                                                                                                          return empty($record->last_user_ticket_reply->hasMedia('file'));
                                                                                                                      }) ,
                                                                                   ]) ,
                                                    Placeholder::make('created_at')
                                                               ->content(fn ( Ticket $record ): string => verta($record->created_at))
                                                               ->translateLabel() ,
                                                    Textarea::make('description')
                                                            ->label('پاسخ ادمین')
                                                            ->required() ,
                                                ])
                                         ->action(function ( Ticket $ticket , array $data ) {
                                             try {
                                                 TicketReply::query()
                                                            ->create([
                                                                         'ticket_id' => $ticket->id ,
                                                                         'admin_id' => auth()->id() ?? 1 ,
                                                                         'description' => $data[ 'description' ],
                                                                     ]);
                                                 $ticket->user->notify(new AdminAnsweredTicketNotification($data[ 'description' ] , $ticket->last_user_ticket_reply->description));
                                             }
                                             catch ( Exception $exception ) {
                                             }
                                             $ticket->ticket_status_id = TicketStatus::ANSWERED;
                                             $ticket->save();
                                         }) ,
                                   Action::make('show_replies')
                                         ->button()
                                         ->outlined()
                                         ->icon('')
                                         ->translateLabel()
                                         ->form([// show ticket replies order by created at
                                                ])
                                         ->action(function ( Ticket $ticket , array $data ) {

                                         }) ,
                               ])
                     ->bulkActions([])
                     ->defaultSort('id' , 'desc');
    }

    public static function getRelations (): array {
        return [//
        ];
    }

    public static function getPages (): array {
        return [
            'index' => Pages\ListTickets::route('/') ,
            'create' => Pages\CreateTicket::route('/create') ,
            'edit' => Pages\EditTicket::route('/{record}/edit') ,
        ];
    }

    public static function getLabel (): ?string {
        return __('Ticket');
    }

    public static function getPluralLabel (): string {
        return __('Tickets');
    }
}
