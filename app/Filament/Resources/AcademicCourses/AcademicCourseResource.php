<?php

namespace App\Filament\Resources\AcademicCourses;

use App\Models\AcademicCourse;
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

class AcademicCourseResource extends Resource
{
    protected static ?string $model = AcademicCourse::class;
    protected static ?int $navigationSort = 30;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;
    protected static string|\UnitEnum|null $navigationGroup = 'Gestión académica';
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $modelLabel = 'curso';
    protected static ?string $pluralModelLabel = 'cursos';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('program_id')->label('Programa académico')->relationship('program', 'name')->searchable()->preload()->required(),
            TextInput::make('code')->label('Código del curso')->required()->maxLength(30),
            TextInput::make('name')->label('Nombre del curso')->required()->maxLength(255),
            TextInput::make('semester_level')->label('Ciclo o semestre')->numeric()->minValue(1)->maxValue(20),
            TextInput::make('credits')->label('Créditos')->numeric()->step(0.5)->minValue(0),
            Toggle::make('is_active')->label('Curso activo')->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('code')->label('Código')->searchable()->sortable(),
            TextColumn::make('name')->label('Curso')->searchable()->sortable(),
            TextColumn::make('program.name')->label('Programa')->searchable()->sortable(),
            TextColumn::make('semester_level')->label('Ciclo')->sortable()->placeholder('—'),
            TextColumn::make('credits')->label('Créditos')->sortable()->placeholder('—'),
            IconColumn::make('is_active')->label('Activo')->boolean(),
        ])->recordActions([EditAction::make(), DeleteAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAcademicCourses::route('/'),
            'create' => CreateAcademicCourse::route('/create'),
            'edit' => EditAcademicCourse::route('/{record}/edit'),
        ];
    }
}

class ListAcademicCourses extends ListRecords
{
    protected static string $resource = AcademicCourseResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()->label('Nuevo curso')];
    }
}

class CreateAcademicCourse extends CreateRecord
{
    protected static string $resource = AcademicCourseResource::class;
}

class EditAcademicCourse extends EditRecord
{
    protected static string $resource = AcademicCourseResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}