<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fakultas extends Model
{
    protected $fillable = ['nama', 'kode'];

    public function penelitian(): HasMany
    {
        return $this->hasMany(Penelitian::class, 'fakultas_id');
    }
}
