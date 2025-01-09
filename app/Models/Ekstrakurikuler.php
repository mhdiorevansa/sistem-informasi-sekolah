<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ekstrakurikuler extends Model
{
    protected $table = 'ekstrakurikuler';
    protected $guarded = [];

    /**
     * The siswa that belong to the Ekstrakurikuler
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function siswa(): BelongsToMany
    {
        return $this->belongsToMany(DataSiswa::class, 'ekstrakurikuler_siswa', 'ekstrakurikuler_id', 'siswa_id');
    }
}
