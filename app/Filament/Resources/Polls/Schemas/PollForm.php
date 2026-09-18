<?php

namespace App\Filament\Resources\Polls\Schemas;

use App\Models\Category;
use App\Models\District;
use App\Models\Province;
use App\Models\Region;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PollForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(12)
            ->components([
                Hidden::make('user_id')
                    ->default(auth()->id())
                    ->dehydrated()
                    ->disabled(),

                Section::make('Contenido')
                    ->columns(12)
                    ->columnSpan(8)
                    ->schema([
                        Select::make('category_id')
                            ->label('Categoría')
                            ->options(Category::query()->pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->columnSpanFull(),

                        TextInput::make('title')
                            ->label('Título')
                            ->required()
                            ->string()
                            ->minLength(2)
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(callable $set, ?string $state) => $set('slug', Str::slug($state ?? '')))
                            ->columnSpanFull(),

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
                            ->columnSpanFull(),

                        Textarea::make('description')
                            ->label('Descripción')
                            ->rows(7)
                            ->columnSpanFull()
                            ->belowContent('Proporcione una descripción detallada de la encuesta.'),
                    ]),

                Section::make('Imagen')
                    ->columnSpan(4)
                    ->schema([
                        FileUpload::make('image')
                            ->label('Imagen principal')
                            ->disk('polls')
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
                            ->belowContent('Seleccione una imagen representativa para la encuesta. Tamaño sugerido 800x600 píxeles.'),
                    ]),

                Section::make('Ámbito de la encuesta')
                    ->columns(12)
                    ->columnSpan(6)
                    ->schema([

                        Select::make('scope')
                            ->label('Ámbito')
                            ->options([
                                'nacional' => 'Nacional',
                                'regional' => 'Regional',
                                'provincial' => 'Provincial',
                                'distrital' => 'Distrital',
                            ])
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (Set $set) {
                                $set('region_id', null);
                                $set('province_id', null);
                                $set('district_id', null);
                            })
                            ->columnSpanFull(),

                        Select::make('region_id')
                            ->label('Región')
                            ->options(fn() => Region::orderBy('name')->pluck('name', 'id'))
                            ->searchable()
                            ->live()
                            ->visible(fn(Get $get) => in_array($get('scope'), ['regional', 'provincial', 'distrital']))
                            ->required(fn(Get $get) => in_array($get('scope'), ['regional', 'provincial', 'distrital']))
                            ->afterStateUpdated(function (Set $set) {
                                $set('province_id', null);
                                $set('district_id', null);
                            })
                            ->columnSpanFull(),

                        Select::make('province_id')
                            ->label('Provincia')
                            ->options(
                                fn(Get $get) =>
                                Province::where('region_id', $get('region_id'))
                                    ->orderBy('name')
                                    ->pluck('name', 'id')
                            )
                            ->searchable()
                            ->live()
                            ->visible(fn(Get $get) => in_array($get('scope'), ['provincial', 'distrital']))
                            ->required(fn(Get $get) => in_array($get('scope'), ['provincial', 'distrital']))
                            ->afterStateUpdated(fn(Set $set) => $set('district_id', null))
                            ->columnSpanFull(),

                        Select::make('district_id')
                            ->label('Distrito')
                            ->options(
                                fn(Get $get) =>
                                District::where('province_id', $get('province_id'))
                                    ->orderBy('name')
                                    ->pluck('name', 'id')
                            )
                            ->searchable()
                            ->visible(fn(Get $get) => $get('scope') === 'distrital')
                            ->required(fn(Get $get) => $get('scope') === 'distrital')
                            ->columnSpanFull(),
                    ]),

                Section::make('Programación')
                    ->columnSpan(6)
                    ->schema([
                        DateTimePicker::make('starts_at')
                            ->label('Fecha de inicio')
                            ->required()
                            ->seconds(false)
                            ->columnSpanFull()
                            ->belowContent('Fechas de inicio de la encuesta.'),

                        DateTimePicker::make('ends_at')
                            ->label('Fecha de finalización')
                            ->required()
                            ->seconds(false)
                            ->columnSpanFull()
                            ->belowContent('Fechas de finalización de la encuesta.'),

                        Select::make('status')
                            ->label('Estado')
                            ->options([
                                'borrador' => 'Borrador',
                                'activo' => 'Activo',
                                'cerrado' => 'Cerrado',
                                'archivado' => 'Archivado',
                            ])
                            ->default('borrador')
                            ->required()
                            ->columnSpanFull()
                            ->belowContent('Seleccione el estado actual de la encuesta.')
                    ]),
            ]);
    }
}
