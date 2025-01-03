<?php

namespace App\Filament\Resources\DataSiswaResource\Pages;

use App\Filament\Resources\DataSiswaResource;
use App\Models\DataSiswa;
use App\Models\LaporanSiswa;
use App\Models\NilaiLaporanSiswa;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Model;

class ListDataSiswas extends ListRecords
{
    protected static string $resource = DataSiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->using(function (array $data): Model {
                $siswa = DataSiswa::create([
                    'nis' => $data['nis'],
                    'gender' => $data['gender'],
                    'nama_lengkap' => $data['nama_lengkap'],
                    'tanggal_lahir' => $data['tanggal_lahir'],
                    'kelas_id' => $data['kelas_id'],
                ]);
                for ($i = 1; $i <= 2; $i++) {
                    $laporan = LaporanSiswa::create([
                        'siswa_id' => $siswa->id,
                        'semester' => $i,
                        'kelas_id' => $siswa['kelas_id'],
                    ]);
                }
                return $laporan;
            }),
        ];
    }
}
