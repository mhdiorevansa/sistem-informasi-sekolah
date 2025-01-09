<?php

namespace App\Filament\Resources\BebanMengajarResource\Pages;

use App\Filament\Resources\BebanMengajarResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBebanMengajars extends ListRecords
{
    protected static string $resource = BebanMengajarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
