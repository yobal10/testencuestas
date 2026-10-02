<?php

namespace App\Filament\Resources\UniversityMembers;

use App\Models\UniversityMember;
use App\Models\User;
use BackedEnum;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
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

class UniversityMemberResource extends Resource
{
    protected static ?string $model = UniversityMember::class;
    protected static ?int $navigationSort = 40;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;
    protected static string|\UnitEnum|null $navigationGroup = 'Gestión académica';
    protected static ?string $recordTitleAttribute = 'institutional_code';
    protected static ?string $modelLabel = 'participante';
    protected static ?string $pluralModelLabel = 'participantes';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('user_id')->label('Usuario')->options(fn (): array => User::query()
                ->orderBy('name')->get()->mapWithKeys(fn (User $user): array => [$user->id => "{$user->name} ({$user->email})"])->all())
                ->searchable()->required()->unique(ignoreRecord: true),
            Select::make('member_type')->label('Tipo de participante')->options([
                'student' => 'Estudiante',
                'teacher' => 'Docente',
                'staff' => 'Personal administrativo',
                'director' => 'Directivo',
            ])->default('student')->required(),
            Select::make('faculty_id')->label('Facultad')->relationship('faculty', 'name')->searchable()->preload(),
            Select::make('program_id')->label('Programa académico')->relationship('program', 'name')->searchable()->preload(),
            TextInput::make('institutional_code')->label('Código institucional')->maxLength(50)->unique(ignoreRecord: true),
            TextInput::make('phone')->label('Celular')->tel()->maxLength(30),
            Select::make('status')->label('Estado')->options(['active' => 'Activo', 'inactive' => 'Inactivo'])->default('active')->required(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('user.name')->label('Participante')->searchable()->sortable(),
            TextColumn::make('user.email')->label('Correo institucional')->searchable(),
            TextColumn::make('member_type')->label('Rol universitario')->formatStateUsing(fn (string $state): string => match ($state) {
                'student' => 'Estudiante', 'teacher' => 'Docente', 'staff' => 'Administrativo', 'director' => 'Directivo', default => $state,
            })->badge(),
            TextColumn::make('faculty.name')->label('Facultad')->placeholder('—'),
            TextColumn::make('program.name')->label('Programa')->placeholder('—'),
            TextColumn::make('institutional_code')->label('Código')->searchable()->placeholder('—'),
            TextColumn::make('status')->label('Estado')->badge(),
        ])->recordActions([EditAction::make(), DeleteAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUniversityMembers::route('/'),
            'create' => CreateUniversityMember::route('/create'),
            'edit' => EditUniversityMember::route('/{record}/edit'),
        ];
    }
}

class ListUniversityMembers extends ListRecords
{
    protected static string $resource = UniversityMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()->label('Registrar participante')];
    }
}

class CreateUniversityMember extends CreateRecord
{
    protected static string $resource = UniversityMemberResource::class;
}

class EditUniversityMember extends EditRecord
{
    protected static string $resource = UniversityMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
