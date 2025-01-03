<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NilaiLaporanSiswa extends Model
{
    protected $table = 'nilai_laporan_siswa';
    protected $guarded = [];

    /**
     * Get the laporanSiswa that owns the NilaiLaporanSiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function laporanSiswa(): BelongsTo
    {
        return $this->belongsTo(LaporanSiswa::class, 'laporan_siswa_id', 'id');
    }

    /**
     * Get the mataPelajaran that owns the NilaiLaporanSiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id', 'id');
    }
}
