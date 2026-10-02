<?php

namespace App\Filament\Resources\Surveys;

use App\Models\Survey;
use BackedEnum;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
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
use Illuminate\Support\Str;

class SurveyResource extends Resource
{
    protected static ?string $model = Survey::class;
    protected static ?int $navigationSort = 10;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;
    protected static string|\UnitEnum|null $navigationGroup = 'Encuestas universitarias';
    protected static ?string $recordTitleAttribute = 'title';
    protected static ?string $modelLabel = 'encuesta';
    protected static ?string $pluralModelLabel = 'encuestas universitarias';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Hidden::make('created_by')->default(fn () => auth()->id()),
            TextInput::make('title')->label('Título de la encuesta')->required()->live(onBlur: true)
                ->afterStateUpdated(fn (callable $set, ?string $state) => $set('slug', Str::slug($state ?? ''))),
            TextInput::make('slug')->label('Identificador web')->required()->unique(ignoreRecord: true),
            Select::make('academic_period_id')->label('Periodo académico')->relationship('period', 'name')->searchable()->preload(),
            Select::make('faculty_id')->label('Facultad')->relationship('faculty', 'name')->searchable()->preload(),
            Select::make('program_id')->label('Programa académico')->relationship('program', 'name')->searchable()->preload(),
            Select::make('course_id')->label('Curso')->relationship('course', 'name')->searchable()->preload(),
            Select::make('survey_type')->label('Tipo de encuesta')->options([
                'student_experience' => 'Experiencia estudiantil', 'teacher_evaluation' => 'Evaluación docente',
                'course_evaluation' => 'Evaluación de curso', 'service_evaluation' => 'Evaluación de servicios', 'institutional' => 'Institucional',
            ])->default('institutional')->required(),
            Select::make('audience')->label('Dirigida a')->options(['all' => 'Comunidad universitaria', 'students' => 'Estudiantes', 'teachers' => 'Docentes', 'staff' => 'Personal administrativo'])->default('all')->required(),
            Select::make('status')->label('Estado')->options(['draft' => 'Borrador', 'published' => 'Publicada', 'active' => 'Activa', 'closed' => 'Cerrada'])->default('draft')->required(),
            Toggle::make('is_anonymous')->label('Respuesta anónima')->default(true),
            DateTimePicker::make('opens_at')->label('Inicio')->seconds(false),
            DateTimePicker::make('closes_at')->label('Cierre')->seconds(false)->after('opens_at'),
            Textarea::make('description')->label('Descripción e instrucciones')->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('title')->label('Encuesta')->searchable()->sortable(),
            TextColumn::make('survey_type_label')->label('Tipo'),
            TextColumn::make('faculty.name')->label('Facultad')->placeholder('Institucional'),
            TextColumn::make('status')->label('Estado')->badge(),
            TextColumn::make('closes_at')->label('Cierre')->dateTime('d/m/Y H:i')->placeholder('Sin fecha'),
            IconColumn::make('is_anonymous')->label('Anónima')->boolean(),
        ])->recordActions([EditAction::make(), DeleteAction::make()]);
    }
    public static function getPages(): array { return ['index' => ListSurveys::route('/'), 'create' => CreateSurvey::route('/create'), 'edit' => EditSurvey::route('/{record}/edit')]; }
}
class ListSurveys extends ListRecords { protected static string $resource = SurveyResource::class; protected function getHeaderActions(): array { return [CreateAction::make()->label('Nueva encuesta')]; } }
class CreateSurvey extends CreateRecord { protected static string $resource = SurveyResource::class; }
class EditSurvey extends EditRecord { protected static string $resource = SurveyResource::class; protected function getHeaderActions(): array { return [DeleteAction::make()]; } }
