<?php

namespace App\Filament\Resources\AsesmenGuruResource\Pages;

use App\Filament\Resources\AsesmenGuruResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAsesmenGuru extends EditRecord
{
    protected static string $resource = AsesmenGuruResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
