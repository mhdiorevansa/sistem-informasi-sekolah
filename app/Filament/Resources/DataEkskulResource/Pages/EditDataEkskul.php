<?php

namespace App\Filament\Resources\DataEkskulResource\Pages;

use App\Filament\Resources\DataEkskulResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDataEkskul extends EditRecord
{
    protected static string $resource = DataEkskulResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
