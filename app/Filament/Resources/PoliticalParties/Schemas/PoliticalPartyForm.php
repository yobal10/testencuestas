<?php

namespace App\Filament\Resources\PoliticalParties\Schemas;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

class PoliticalPartyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(12)
            ->components([
                Section::make('Información principal')
                    ->columns(12)
                    ->columnSpan(8)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre')
                            ->required()
                            ->string()
                            ->minLength(2)
                            ->maxLength(255)
                            ->autofocus()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(callable $set, ?string $state) => $set('slug', Str::slug($state ?? '')))
                            ->columnSpan(6),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->minLength(2)
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->dehydrated()
                            ->regex('/^[a-z0-9]+(?:-[a-z0-9]+)*$/')
                            ->validationMessages([
                                'regex' => 'El formato del slug debe ser minúsculas, números y guiones (ej: mi-categoria-1).',
                            ])
                            ->disabled(fn($record) => $record !== null)
                            ->columnSpan(6),

                        TextInput::make('acronym')
                            ->label('Acrónimo')
                            ->required()
                            ->minLength(2)
                            ->maxLength(10)
                            ->regex('/^[A-Z0-9]+$/')
                            ->validationMessages([
                                'regex' => 'Solo letras mayúsculas y números.',
                            ])
                            ->placeholder('Ej: FP')
                            ->columnSpan(4),

                        Textarea::make('description')
                            ->label('Descripción')
                            ->rows(4)
                            ->maxLength(65535)
                            ->nullable()
                            ->columnSpanFull(),
                    ]),

                Section::make('Identidad visual')
                    ->columns(12)
                    ->columnSpan(4)
                    ->schema([
                        FileUpload::make('logo')
                            ->label('Logo')
                            ->disk('logos')
                            ->image()
                            ->imageEditor()
                            ->imageEditorAspectRatioOptions([
                                null,
                                '1:1',
                                '4:3',
                                '16:9',
                            ])
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'])
                            ->maxSize(2048)
                            ->columnSpanFull(),

                        ColorPicker::make('color')
                            ->label('Color principal')
                            ->required()
                            ->default('#000000')
                            ->regex('/^#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})\b$/')
                            ->validationMessages([
                                'regex' => 'El formato del color debe ser #RRGGBB o #RGB.',
                            ])
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
