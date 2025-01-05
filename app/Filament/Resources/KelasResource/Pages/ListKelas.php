<?php

namespace App\Filament\Resources\KelasResource\Pages;

use App\Filament\Resources\KelasResource;
use App\Models\Kelas;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKelas extends ListRecords
{
    protected static string $resource = KelasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->using(function (array $data): Kelas {
                $tingkatan = Kelas::orderByDesc('tingkatan')->first()?->tingkatan ?? 0;
                $tingkatan++;
                $kelas = Kelas::create([
                    'nama_kelas' => $data['nama_kelas'],
                    'tingkatan' => $tingkatan,
                ]);
                return $kelas;
            }),
        ];
    }
}
