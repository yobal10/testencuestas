<?php

namespace App\Filament\Resources\Polls\Pages;

use App\Filament\Resources\Polls\PollResource;
use Asmit\ResizedColumn\HasResizableColumn;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPolls extends ListRecords
{
    use HasResizableColumn;

    protected static string $resource = PollResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
