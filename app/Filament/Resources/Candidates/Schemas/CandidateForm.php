<?php

namespace App\Filament\Resources\Candidates\Schemas;

use App\Models\PoliticalParty;
use App\Models\Poll;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CandidateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(12)
            ->components([
                Section::make('Información del candidato')
                    ->columns(12)
                    ->columnSpan(8)
                    ->schema([
                        Select::make('poll_id')
                            ->label('Encuesta')
                            ->options(Poll::query()->pluck('title', 'id'))
                            ->searchable()
                            ->required()
                            ->columnSpan(6),

                        Select::make('political_party_id')
                            ->label('Partido Político')
                            ->options(PoliticalParty::query()->pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->columnSpan(6),

                        TextInput::make('name')
                            ->label('Nombres y Apellidos')
                            ->required()
                            ->string()
                            ->minLength(2)
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(callable $set, ?string $state) => $set('slug', Str::slug($state ?? '')))
                            ->columnSpan(6)
                            ->belowContent('Nombre completo del candidato.'),

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
                            ->columnSpan(6)
                            ->belowContent('Identificador único para URLs. Se genera automáticamente a partir del nombre.'),

                        TextInput::make('number')
                            ->label('Número de candidato')
                            ->numeric()
                            ->columnSpan(4)
                            ->belowContent('Número que identifica al candidato en la encuesta.'),

                        Textarea::make('biography')
                            ->label('Biografía')
                            ->rows(6)
                            ->columnSpanFull()
                            ->belowContent('Descripción del candidato, trayectoria, experiencia, etc.'),
                    ]),

                Section::make('Foto')
                    ->columnSpan(4)
                    ->schema([
                        FileUpload::make('photo')
                            ->label('Foto del candidato')
                            ->disk('candidates_photos')
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
                            ->columnSpanFull()
                            ->belowContent('Sube una foto clara y profesional del candidato. Formatos aceptados: jpg, png, webp, svg. Tamaño máximo: 2MB.'),
                    ]),
            ]);
    }
}
