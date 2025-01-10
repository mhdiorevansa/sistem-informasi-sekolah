<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    /**
     * Get the alumni associated with the DataSiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function alumni(): HasOne
    {
        return $this->hasOne(Alumni::class, 'siswa_id', 'id');
    }

    /**
     * The ekstrakurikuler that belong to the Ekstrakurikuler
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ekstrakurikuler(): BelongsToMany
    {
        return $this->belongsToMany(Ekstrakurikuler::class, 'ekstrakurikuler_siswa', 'siswa_id', 'ekstrakurikuler_id');
    }

    /**
     * Get all of the pembayaranSpp for the DataSiswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pembayaranSpp(): HasMany
    {
        return $this->hasMany(PembayaranSpp::class, 'siswa_id', 'id');
    }

    protected function namaLengkap(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => \ucfirst($value),
        );
    }
}
