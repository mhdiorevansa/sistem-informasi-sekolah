<?php

namespace App\Filament\Resources\JadwalMataPelajaranResource\Pages;

use App\Filament\Resources\JadwalMataPelajaranResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJadwalMataPelajaran extends EditRecord
{
    protected static string $resource = JadwalMataPelajaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
