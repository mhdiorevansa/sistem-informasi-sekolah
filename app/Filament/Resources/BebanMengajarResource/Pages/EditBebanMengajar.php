<?php

namespace App\Filament\Resources\BebanMengajarResource\Pages;

use App\Filament\Resources\BebanMengajarResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBebanMengajar extends EditRecord
{
    protected static string $resource = BebanMengajarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
