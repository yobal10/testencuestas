<?php

namespace App\Filament\Resources\Faculties;

use App\Filament\Resources\Faculties\Pages\CreateFaculty;
use App\Filament\Resources\Faculties\Pages\EditFaculty;
use App\Filament\Resources\Faculties\Pages\ListFaculties;
use App\Models\Faculty;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class FacultyResource extends Resource
{
    protected static ?string $model = Faculty::class;
    protected static ?int $navigationSort = 10;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingLibrary;
    protected static string|\UnitEnum|null $navigationGroup = 'Gestión académica';
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $modelLabel = 'facultad';
    protected static ?string $pluralModelLabel = 'facultades';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->label('Nombre de la facultad')->required()->live(onBlur: true)
                ->afterStateUpdated(fn (callable $set, ?string $state) => $set('slug', Str::slug($state ?? ''))),
            TextInput::make('code')->label('Código')->required()->maxLength(30)->unique(ignoreRecord: true),
            TextInput::make('slug')->label('Identificador web')->required()->unique(ignoreRecord: true),
            TextInput::make('dean_name')->label('Decano(a) o responsable')->maxLength(255),
            Toggle::make('is_active')->label('Facultad activa')->default(true),
            Textarea::make('description')->label('Descripción')->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')->label('Facultad')->searchable()->sortable(),
            TextColumn::make('code')->label('Código')->searchable(),
            TextColumn::make('dean_name')->label('Responsable')->toggleable(),
            IconColumn::make('is_active')->label('Activa')->boolean(),
        ])->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFaculties::route('/'),
            'create' => CreateFaculty::route('/create'),
            'edit' => EditFaculty::route('/{record}/edit'),
        ];
    }
}
