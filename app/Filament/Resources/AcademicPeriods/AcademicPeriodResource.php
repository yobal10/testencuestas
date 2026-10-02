<?php

namespace App\Filament\Resources\AcademicPeriods;

use App\Models\AcademicPeriod;
use BackedEnum;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AcademicPeriodResource extends Resource
{
    protected static ?string $model = AcademicPeriod::class;
    protected static ?int $navigationSort = 30;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;
    protected static string|\UnitEnum|null $navigationGroup = 'Gestión académica';
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $modelLabel = 'periodo académico';
    protected static ?string $pluralModelLabel = 'periodos académicos';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->label('Nombre')->required(),
            TextInput::make('code')->label('Código')->required()->maxLength(30)->unique(ignoreRecord: true)->placeholder('2026-I'),
            DatePicker::make('starts_on')->label('Inicio')->required(),
            DatePicker::make('ends_on')->label('Fin')->required()->afterOrEqual('starts_on'),
            Select::make('status')->label('Estado')->options(['planned' => 'Planificado', 'active' => 'Activo', 'closed' => 'Cerrado'])->default('planned')->required(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')->label('Periodo')->searchable()->sortable(), TextColumn::make('code')->label('Código'),
            TextColumn::make('starts_on')->label('Inicio')->date('d/m/Y'), TextColumn::make('ends_on')->label('Fin')->date('d/m/Y'),
            TextColumn::make('status')->label('Estado')->badge(),
        ])->recordActions([EditAction::make(), DeleteAction::make()]);
    }
    public static function getPages(): array { return ['index' => ListAcademicPeriods::route('/'), 'create' => CreateAcademicPeriod::route('/create'), 'edit' => EditAcademicPeriod::route('/{record}/edit')]; }
}
class ListAcademicPeriods extends ListRecords { protected static string $resource = AcademicPeriodResource::class; protected function getHeaderActions(): array { return [CreateAction::make()->label('Nuevo periodo')]; } }
class CreateAcademicPeriod extends CreateRecord { protected static string $resource = AcademicPeriodResource::class; }
class EditAcademicPeriod extends EditRecord { protected static string $resource = AcademicPeriodResource::class; protected function getHeaderActions(): array { return [DeleteAction::make()]; } }
