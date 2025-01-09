<?php

namespace App\Filament\Resources\AsesmenGuruResource\Pages;

use App\Filament\Resources\AsesmenGuruResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAsesmenGurus extends ListRecords
{
    protected static string $resource = AsesmenGuruResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
