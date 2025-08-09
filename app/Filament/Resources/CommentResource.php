<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentResource\Pages;
use App\Filament\Resources\CommentResource\RelationManagers;
use App\Models\Comment;
use App\Models\Ticket;
use App\Models\TicketStatus;
use App\Notifications\AdminAnsweredTicketNotification;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CommentResource extends Resource {
    protected static ?string $model          = Comment::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';

    public static function form ( Form $form ): Form {
        return $form->schema([
                                 Forms\Components\Textarea::make('text')
                                                          ->required()
                                                          ->translateLabel() ,
                             ]);
    }

    public static function table ( Table $table ): Table {
        return $table->columns([
                                   TextColumn::make('id')
                                             ->translateLabel() ,
                                   TextColumn::make('user.full_name')
                                             ->translateLabel() ,
                                   TextColumn::make('text')
                                             ->translateLabel() ,
                                   Tables\Columns\ToggleColumn::make('verified')
                                                              ->translateLabel() ,
                               ])
                     ->filters([//
                               ])
                     ->actions([
                                   Tables\Actions\EditAction::make() ,
                                   Tables\Actions\DeleteAction::make() ,
                                   Action::make('answer_a_comment')
                                         ->button()
                                       ->label('پاسخ دادن')
                                         ->outlined()
                                         ->icon('heroicon-m-pencil-square')
                                         ->translateLabel()
                                         ->form([
                                                    Textarea::make('text_of_admin')
                                                            ->label('پاسخ ادمین')
                                                            ->required() ,
                                                ])
                                         ->action(function ( Comment $comment , array $data ) {
                                             Comment::query()
                                                    ->create([
                                                                 'user_id' => 2 ,
                                                                 'text' => $data[ 'text_of_admin' ] ,
                                                                 'commentable_id' => $comment->commentable_id ,
                                                                 'commentable_type' => $comment->commentable_type ,
                                                                 'parent_id' => $comment->id ,
                                                                 'verified' => true,
                                                             ]);
                                         }) ,
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
            'index' => Pages\ListComments::route('/') ,
            'create' => Pages\CreateComment::route('/create') ,
            'edit' => Pages\EditComment::route('/{record}/edit') ,
        ];
    }

    public static function getLabel (): ?string {
        return __('Comment');
    }

    public static function getPluralLabel (): string {
        return __('Comments');
    }
}
