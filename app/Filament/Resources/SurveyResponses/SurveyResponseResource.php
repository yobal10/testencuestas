<?php

namespace App\Filament\Resources\SurveyResponses;

use App\Models\SurveyResponse;
use BackedEnum;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SurveyResponseResource extends Resource
{
    protected static ?string $model = SurveyResponse::class;
    protected static ?int $navigationSort = 30;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;
    protected static string|\UnitEnum|null $navigationGroup = 'Encuestas universitarias';
    protected static ?string $modelLabel = 'respuesta';
    protected static ?string $pluralModelLabel = 'respuestas';

    public static function form(Schema $schema): Schema
    {
        return $schema;
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('survey.title')->label('Encuesta')->searchable()->sortable(),
            TextColumn::make('respondent.name')->label('Participante')->placeholder('Respuesta anónima')->searchable(),
            TextColumn::make('answers_count')->label('Respuestas registradas')->counts('answers'),
            TextColumn::make('submitted_at')->label('Enviada el')->dateTime('d/m/Y H:i')->sortable()->placeholder('En progreso'),
            TextColumn::make('status')->label('Estado')->badge(),
        ])->defaultSort('submitted_at', 'desc');
    }

    public static function getPages(): array
    {
        return ['index' => ListSurveyResponses::route('/')];
    }
}

class ListSurveyResponses extends ListRecords
{
    protected static string $resource = SurveyResponseResource::class;
}
