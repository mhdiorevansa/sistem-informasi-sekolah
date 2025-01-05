<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MataPelajaran extends Model
{
    protected $table = 'mata_pelajaran';
    protected $guarded = [];

    /**
     * Get all of the nilaiLaporanSiswa for the MataPelajaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function nilaiLaporanSiswa(): HasMany
    {
        return $this->hasMany(NilaiLaporanSiswa::class, 'mata_pelajaran_id', 'id');
    }

    /**
     * Get the pengampu that owns the MataPelajaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'pengampu', 'id');
    }

    /**
     * Get the kelasId that owns the MataPelajaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }

    /**
     * Get all of the jadwalMataPelajaran for the MataPelajaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jadwalMataPelajaran(): HasMany
    {
        return $this->hasMany(JadwalMataPelajaran::class, 'mata_pelajaran_id', 'id');
    }
}
