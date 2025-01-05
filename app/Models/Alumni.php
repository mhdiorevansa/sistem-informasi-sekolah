<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Alumni extends Model
{
    protected $table = 'alumni';
    protected $guarded = [];
    
    /**
     * Get the siswa associated with the Alumni
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siswa(): BelongsTo
    {
        return $this->BelongsTo(DataSiswa::class, 'siswa_id', 'id');
    }
}
