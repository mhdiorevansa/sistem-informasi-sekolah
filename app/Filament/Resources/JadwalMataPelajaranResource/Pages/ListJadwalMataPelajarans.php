<?php

namespace App\Filament\Resources\JadwalMataPelajaranResource\Pages;

use App\Filament\Resources\JadwalMataPelajaranResource;
use App\Models\JadwalMataPelajaran;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListJadwalMataPelajarans extends ListRecords
{
    protected static string $resource = JadwalMataPelajaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}


