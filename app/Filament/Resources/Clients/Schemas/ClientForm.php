<?php

namespace App\Filament\Resources\Clients\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ClientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('company_name')
                    ->required(),
                TextInput::make('contact_name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('website')
                    ->type('text')
                    ->rule('url')
                    ->mutateStateForValidationUsing(
                        static fn (?string $state): ?string => self::normalizeWebsite($state),
                    )
                    ->dehydrateStateUsing(
                        static fn (?string $state): ?string => self::normalizeWebsite($state),
                    ),
                Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'lead' => 'Lead',
                    ])
                    ->default('active')
                    ->required(),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }

    private static function normalizeWebsite(?string $website): ?string
    {
        $website = trim((string) $website);

        if ($website === '') {
            return null;
        }

        if (preg_match('/^[a-z][a-z0-9+.-]*:\/\//i', $website) === 1) {
            return $website;
        }

        return "https://{$website}";
    }
}
