<?php

namespace App\Filament\Resources\SurveyQuestions;

use App\Models\SurveyQuestion;
use BackedEnum;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
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

class SurveyQuestionResource extends Resource
{
    protected static ?string $model = SurveyQuestion::class;
    protected static ?int $navigationSort = 20;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQuestionMarkCircle;
    protected static string|\UnitEnum|null $navigationGroup = 'Encuestas universitarias';
    protected static ?string $recordTitleAttribute = 'prompt';
    protected static ?string $modelLabel = 'pregunta';
    protected static ?string $pluralModelLabel = 'preguntas';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('survey_id')->label('Encuesta')->relationship('survey', 'title')->searchable()->preload()->required(),
            Select::make('question_type')->label('Tipo de respuesta')->options(['rating' => 'Escala de 1 a 5', 'text' => 'Texto libre'])->default('rating')->required(),
            Textarea::make('prompt')->label('Pregunta')->required()->columnSpanFull(),
            Textarea::make('help_text')->label('Texto de ayuda')->columnSpanFull(),
            TextInput::make('sort_order')->label('Orden')->numeric()->default(0)->required(),
            Toggle::make('is_required')->label('Respuesta obligatoria')->default(true),
        ])->columns(2);
    }
    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('survey.title')->label('Encuesta')->limit(35)->searchable(),
            TextColumn::make('prompt')->label('Pregunta')->limit(70)->searchable(),
            TextColumn::make('question_type')->label('Tipo de respuesta')->badge()->formatStateUsing(fn (string $state): string => match ($state) {
                'rating' => 'Escala de 1 a 5',
                'text' => 'Respuesta abierta',
                default => $state,
            }),
            TextColumn::make('sort_order')->label('Orden')->sortable(),
            IconColumn::make('is_required')->label('Obligatoria')->boolean(),
        ])->recordActions([EditAction::make(), DeleteAction::make()]);
    }
    public static function getPages(): array { return ['index' => ListSurveyQuestions::route('/'), 'create' => CreateSurveyQuestion::route('/create'), 'edit' => EditSurveyQuestion::route('/{record}/edit')]; }
}
class ListSurveyQuestions extends ListRecords { protected static string $resource = SurveyQuestionResource::class; protected function getHeaderActions(): array { return [CreateAction::make()->label('Nueva pregunta')]; } }
class CreateSurveyQuestion extends CreateRecord { protected static string $resource = SurveyQuestionResource::class; }
class EditSurveyQuestion extends EditRecord { protected static string $resource = SurveyQuestionResource::class; protected function getHeaderActions(): array { return [DeleteAction::make()]; } }
