<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ekstrakurikuler extends Model
{
    protected $table = 'ekstrakurikuler';
    protected $guarded = [];

    /**
     * The kelas that belong to the Ekstrakurikuler
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function kelas(): BelongsToMany
    {
        return $this->belongsToMany(Kelas::class, 'ekstrakurikuler_kelas', 'ekstrakurikuler_id', 'kelas_id');
    }
}
