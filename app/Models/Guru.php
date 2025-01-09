<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guru extends Model
{
    protected $table = 'guru';
    protected $guarded = [];

    /**
     * The kelas that belong to the Guru
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function kelas(): BelongsToMany
    {
        return $this->belongsToMany(Kelas::class, 'wali_kelas', 'guru_id', 'kelas_id');
    }

    /**
     * Get all of the comments for the Guru
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mataPelajaran(): HasMany
    {
        return $this->hasMany(MataPelajaran::class, 'pengampu', 'id');
    }

    /**
     * Get all of the jadwalMataPelajaran for the Guru
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jadwalMataPelajaran(): HasMany
    {
        return $this->hasMany(JadwalMataPelajaran::class, 'guru_id', 'id');
    }

    /**
     * Get the user that owns the Guru
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function asesmen(): hasMany
    {
        return $this->hasMany(AsesmenGuru::class, 'guru_id', 'id');
    }
}
