<?php

namespace App\Filament\Resources\AcademicPrograms;

use App\Models\AcademicProgram;
use BackedEnum;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class AcademicProgramResource extends Resource
{
    protected static ?string $model = AcademicProgram::class;
    protected static ?int $navigationSort = 20;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;
    protected static string|\UnitEnum|null $navigationGroup = 'Gestión académica';
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $modelLabel = 'programa académico';
    protected static ?string $pluralModelLabel = 'programas académicos';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('faculty_id')->label('Facultad')->relationship('faculty', 'name')->searchable()->preload()->required(),
            TextInput::make('name')->label('Nombre del programa')->required()->live(onBlur: true)
                ->afterStateUpdated(fn (callable $set, ?string $state) => $set('slug', Str::slug($state ?? ''))),
            TextInput::make('code')->label('Código')->required()->maxLength(30)->unique(ignoreRecord: true),
            TextInput::make('slug')->label('Identificador web')->required()->unique(ignoreRecord: true),
            Select::make('degree_level')->label('Nivel')->options([
                'pregrado' => 'Pregrado', 'posgrado' => 'Posgrado', 'segunda_especialidad' => 'Segunda especialidad',
            ])->default('pregrado')->required(),
            TextInput::make('duration_semesters')->label('Duración (semestres)')->numeric()->minValue(1)->maxValue(20),
            Toggle::make('is_active')->label('Programa activo')->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')->label('Programa')->searchable()->sortable(),
            TextColumn::make('faculty.name')->label('Facultad')->searchable()->sortable(),
            TextColumn::make('degree_level')->label('Nivel')->badge()->formatStateUsing(fn (string $state): string => match ($state) {
                'pregrado' => 'Pregrado',
                'posgrado' => 'Posgrado',
                'segunda_especialidad' => 'Segunda especialidad',
                default => $state,
            }),
            IconColumn::make('is_active')->label('Activo')->boolean(),
        ])->recordActions([EditAction::make(), DeleteAction::make()]);
    }

    public static function getPages(): array
    {
        return ['index' => ListAcademicPrograms::route('/'), 'create' => CreateAcademicProgram::route('/create'), 'edit' => EditAcademicProgram::route('/{record}/edit')];
    }
}

class ListAcademicPrograms extends ListRecords
{
    protected static string $resource = AcademicProgramResource::class;
    protected function getHeaderActions(): array { return [CreateAction::make()->label('Nuevo programa')]; }
}

class CreateAcademicProgram extends CreateRecord { protected static string $resource = AcademicProgramResource::class; }

class EditAcademicProgram extends EditRecord
{
    protected static string $resource = AcademicProgramResource::class;
    protected function getHeaderActions(): array { return [DeleteAction::make()]; }
}
