<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre completo')
                    ->required()
                    ->maxLength(100),

                TextInput::make('email')
                    ->label('Correo electrónico')
                    ->email()
                    ->required(),

                Hidden::make('email_verified_at')
                    ->default(now())
                    ->dehydrated()
                    ->disabled(),

                TextInput::make('password')
                    ->label('Contraseña')
                    ->password()
                    ->required(fn (string $context): bool => $context === 'create')
                    ->dehydrated(fn ($state) => filled($state))
                    ->revealable()
                    ->minLength(8)
                    ->confirmed(),

                TextInput::make('password_confirmation')
                    ->label('Confirmar Contraseña')
                    ->password()
                    ->required(fn (string $context): bool => $context === 'create')
                    ->dehydrated(false)
                    ->revealable()
                    ->minLength(8),

                Select::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->label('Roles')
                    ->required(),

                Toggle::make('status')
                    ->label('¿Está activo?')
                    ->default(true)
                    ->belowContent('Si esta activo, el usuario podrá acceder al panel administrador'),
            ]);
    }
}
