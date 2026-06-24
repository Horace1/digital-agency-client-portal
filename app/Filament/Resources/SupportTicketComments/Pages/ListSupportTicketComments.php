<?php

namespace App\Filament\Resources\SupportTicketComments\Pages;

use App\Filament\Resources\SupportTicketComments\SupportTicketCommentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSupportTicketComments extends ListRecords
{
    protected static string $resource = SupportTicketCommentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
