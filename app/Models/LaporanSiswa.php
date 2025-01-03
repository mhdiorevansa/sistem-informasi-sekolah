<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LaporanSiswa extends Model
{
    protected $table = 'laporan_siswa';
    protected $guarded = [];

    /**
     * Get the siswa that owns the LaporanSiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(DataSiswa::class, 'siswa_id', 'id');
    }

    /**
     * Get all of the NilaiLaporanSiswa for the LaporanSiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function nilaiLaporanSiswa(): HasMany
    {
        return $this->hasMany(NilaiLaporanSiswa::class, 'laporan_siswa_id', 'id');
    }

    /**
     * Get the kelas that owns the LaporanSiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }
}
