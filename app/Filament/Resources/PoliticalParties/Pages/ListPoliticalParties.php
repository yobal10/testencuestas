<?php

namespace App\Filament\Resources\PoliticalParties\Pages;

use App\Filament\Resources\PoliticalParties\PoliticalPartyResource;
use Asmit\ResizedColumn\HasResizableColumn;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPoliticalParties extends ListRecords
{
    use HasResizableColumn;

    protected static string $resource = PoliticalPartyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
