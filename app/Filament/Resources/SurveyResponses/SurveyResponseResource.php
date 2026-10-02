<?php

namespace App\Filament\Resources\SurveyResponses;

use App\Models\SurveyResponse;
use BackedEnum;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
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

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Datos de la participación')->columns(2)->schema([
                TextEntry::make('survey.title')->label('Encuesta'),
                TextEntry::make('respondent.name')->label('Participante')->placeholder('Respuesta anónima'),
                TextEntry::make('status')->label('Estado')->badge()->formatStateUsing(fn (string $state): string => match ($state) {
                    'submitted' => 'Enviada',
                    'in_progress' => 'En progreso',
                    default => $state,
                }),
                TextEntry::make('submitted_at')->label('Enviada el')->dateTime('d/m/Y H:i')->placeholder('Aún no enviada'),
            ]),
            Section::make('Respuestas de la encuesta')->schema([
                RepeatableEntry::make('answers')->label('Detalle por pregunta')->schema([
                    TextEntry::make('question.prompt')->label('Pregunta'),
                    TextEntry::make('answer_text')->label('Respuesta escrita')->placeholder('Sin respuesta escrita'),
                    TextEntry::make('answer_numeric')->label('Calificación')->placeholder('Sin calificación'),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('survey.title')->label('Encuesta')->searchable()->sortable(),
            TextColumn::make('respondent.name')->label('Participante')->placeholder('Respuesta anónima')->searchable(),
            TextColumn::make('answers_count')->label('Respuestas registradas')->counts('answers'),
            TextColumn::make('submitted_at')->label('Enviada el')->dateTime('d/m/Y H:i')->sortable()->placeholder('En progreso'),
            TextColumn::make('status')->label('Estado')->badge()->formatStateUsing(fn (string $state): string => match ($state) {
                'submitted' => 'Enviada',
                'in_progress' => 'En progreso',
                default => $state,
            }),
        ])->defaultSort('submitted_at', 'desc')
            ->recordActions([ViewAction::make()->label('Ver respuestas')]);
    }

    public static function getPages(): array
    {
            return [
                'index' => ListSurveyResponses::route('/'),
                'view' => ViewSurveyResponse::route('/{record}'),
            ];
    }
}

class ListSurveyResponses extends ListRecords
{
    protected static string $resource = SurveyResponseResource::class;
}

class ViewSurveyResponse extends ViewRecord
{
    protected static string $resource = SurveyResponseResource::class;
}
