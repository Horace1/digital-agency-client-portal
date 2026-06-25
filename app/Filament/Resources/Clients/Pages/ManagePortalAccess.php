<?php

namespace App\Filament\Resources\Clients\Pages;

use App\Filament\Resources\Clients\ClientResource;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Hash;

class ManagePortalAccess extends ManageRelatedRecords
{
    protected static string $resource = ClientResource::class;

    protected static string $relationship = 'users';

    protected static ?string $relationshipTitle = 'Manage Portal Access';

    public function getTitle(): string|Htmlable
    {
        return "Manage Portal Access for {$this->getRecordTitle()}";
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('password')
                    ->password()
                    ->required()
                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state)),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modelLabel('portal user')
            ->pluralModelLabel('portal users')
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Grant Portal Access')
                    ->fillForm(fn (): array => [
                        'name' => $this->getOwnerRecord()->contact_name,
                        'email' => $this->getOwnerRecord()->email,
                    ])
                    ->modalSubmitActionLabel('Grant Portal Access')
                    ->createAnother(false),
            ]);
    }
}
