<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Spp extends Model
{
    protected $table = 'spp';
    protected $guarded = [];

    /**
     * Get all of the periode for the Spp
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pembayaranSpp(): HasMany
    {
        return $this->hasMany(PembayaranSpp::class, 'periode_spp', 'id');
    }
}
