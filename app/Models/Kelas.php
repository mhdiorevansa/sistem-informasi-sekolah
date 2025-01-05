<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelas extends Model
{

    protected $table = 'kelas';
    protected $guarded = [];

    /**
     * Get all of the siswa for the Kelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function siswa(): HasMany
    {
        return $this->hasMany(DataSiswa::class, 'kelas_id', 'id');
    }

    /**
     * The guru that belong to the Kelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function guru(): BelongsToMany
    {
        return $this->belongsToMany(Guru::class, 'wali_kelas', 'kelas_id', 'guru_id');
    }

    /**
     * Get all of the mataPelajaran for the Kelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mataPelajaran(): HasMany
    {
        return $this->hasMany(MataPelajaran::class, 'kelas_id', 'id');
    }

    /**
     * Get all of the laporanSiswa for the Kelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function laporanSiswa(): HasMany
    {
        return $this->hasMany(LaporanSiswa::class, 'kelas_id', 'id');
    }

    /**
     * Get all of the jadwalMataPelajaran for the Kelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jadwalMataPelajaran(): HasMany
    {
        return $this->hasMany(JadwalMataPelajaran::class, 'kelas_id', 'id');
    }

    /**
     * The ekstrakurikuler that belong to the Kelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ekstrakurikuler(): BelongsToMany
    {
        return $this->belongsToMany(Ekstrakurikuler::class, 'ekstrakurikuler_kelas', 'kelas_id', 'ekstrakurikuler_id');
    }
}
