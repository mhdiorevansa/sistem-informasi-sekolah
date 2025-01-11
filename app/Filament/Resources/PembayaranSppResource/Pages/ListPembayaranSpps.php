<?php

namespace App\Filament\Resources\PembayaranSppResource\Pages;

use App\Filament\Resources\PembayaranSppResource;
use App\Models\PembayaranSpp;
use App\Models\Spp;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Model;

class ListPembayaranSpps extends ListRecords
{
    protected static string $resource = PembayaranSppResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->using(function (array $data): PembayaranSpp {
                    $periodeSpp = $data['periode_spp'];
                    $spp = Spp::where('id', $periodeSpp)->value('harga_spp');
                    $statusBayar = $data['jumlah_bayar'] >= $spp ? 'Lunas' : 'Belum Lunas';
                    $pembayaranSpp = PembayaranSpp::create([
                        'siswa_id' => $data['siswa_id'],
                        'periode_spp' => $periodeSpp,
                        'jumlah_bayar' => $data['jumlah_bayar'],
                        'tanggal_bayar' => $data['tanggal_bayar'],
                        'status_bayar' => $statusBayar,
                    ]);
                    return $pembayaranSpp;
                }),
        ];
    }
}
