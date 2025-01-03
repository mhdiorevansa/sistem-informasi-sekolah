<?php

namespace App\Filament\Resources\LaporanSiswaResource\Pages;

use App\Filament\Resources\LaporanSiswaResource;
use App\Models\LaporanSiswa;
use App\Models\NilaiLaporanSiswa;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Model;

class ListLaporanSiswas extends ListRecords
{
    protected static string $resource = LaporanSiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make()
            //     ->using(function (array $data): Model {
            //         $laporan = LaporanSiswa::create([
            //             'siswa_id' => $data['siswa_id'],
            //             'semester' => $data['semester'],
            //             'kelas_id' => $data['kelas_id'],
            //         ]);
            //         if (isset($data['nilaiLaporanSiswa'])) {
            //             foreach ($data['nilaiLaporanSiswa'] as $nilai) {
            //                 NilaiLaporanSiswa::create([
            //                     'laporan_siswa_id' => $laporan->id,
            //                     'mata_pelajaran_id' => $nilai['mata_pelajaran_id'],
            //                     'nilai' => $nilai['nilai'],
            //                     'alfa' => $nilai['alfa'],
            //                     'izin' => $nilai['izin'],
            //                     'sakit' => $nilai['sakit'],
            //                 ]);
            //             }
            //         }
            //         return $laporan;
            //     }),
        ];
    }
}
