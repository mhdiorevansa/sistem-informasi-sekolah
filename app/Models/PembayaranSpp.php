<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PembayaranSpp extends Model
{
    protected $table = 'pembayaran_spp';
    protected $guarded = [];

    /**
     * Get the spp that owns the PembayaranSpp
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function spp(): BelongsTo
    {
        return $this->belongsTo(Spp::class, 'periode_spp', 'id');
    }

    /**
     * Get the siswa that owns the PembayaranSpp
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(DataSiswa::class, 'siswa_id', 'id');
    }
}
