<?php

namespace App\Filament\Resources\SupportTicketComments\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SupportTicketCommentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('support_ticket_id')
                    ->relationship('supportTicket', 'title')
                    ->required(),
                Textarea::make('body')
                    ->required()
                    ->rows(5)
                    ->columnSpanFull(),
                Toggle::make('is_internal')
                    ->default(false),
            ]);
    }
}
