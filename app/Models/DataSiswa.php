<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DataSiswa extends Model
{
    protected $table = 'data_siswa';
    protected $guarded = [];

    /**
     * Get the kelas that owns the DataSiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }

    /**
     * Get all of the laporanSiswa for the DataSiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function laporanSiswa(): HasMany
    {
        return $this->hasMany(LaporanSiswa::class, 'siswa_id', 'id');
    }
}
