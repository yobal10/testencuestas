<?php

namespace App\Filament\Resources\Votes;

use App\Filament\Resources\Votes\Pages\CreateVote;
use App\Filament\Resources\Votes\Pages\EditVote;
use App\Filament\Resources\Votes\Pages\ListVotes;
use App\Filament\Resources\Votes\Pages\ViewVote;
use App\Filament\Resources\Votes\Schemas\VoteForm;
use App\Filament\Resources\Votes\Schemas\VoteInfolist;
use App\Filament\Resources\Votes\Tables\VotesTable;
use App\Models\Vote;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class VoteResource extends Resource
{
    protected static ?string $model = Vote::class;

    protected static ?int $navigationSort = 50;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCheckCircle;

    protected static string|\UnitEnum|null $navigationGroup = 'Sistema Electoral';

    protected static ?string $recordTitleAttribute = 'code';

    protected static ?string $modelLabel = 'voto';

    protected static ?string $pluralModelLabel = 'votos';

    // protected static string|\Illuminate\Contracts\Support\Htmlable|null $navigationBadgeTooltip = 'Total de votos registrados';

    // public static function getNavigationBadge(): ?string
    // {
    //     return (string) \App\Models\Vote::count();
    // }

    public static function infolist(Schema $schema): Schema
    {
        return VoteInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VotesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVotes::route('/'),
            'view' => ViewVote::route('/{record}'),
        ];
    }
}
