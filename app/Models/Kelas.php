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
}
