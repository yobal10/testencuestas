<?php

namespace App\Filament\Resources\Votes\Pages;

use App\Filament\Resources\Votes\VoteResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewVote extends ViewRecord
{
    protected static string $resource = VoteResource::class;

    public function getTitle(): string
    {
        return 'Detalle del voto ' . $this->record->code;
    }

    protected function getHeaderActions(): array
    {
        return [
            // EditAction::make(),
        ];
    }
}
