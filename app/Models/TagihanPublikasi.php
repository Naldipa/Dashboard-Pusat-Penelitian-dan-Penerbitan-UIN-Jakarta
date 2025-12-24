<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagihanPublikasi extends Model
{
    protected $fillable = [
        'no_reg',
        'judul',
        'ketua',
        'fakultas',
        'artikel_jurnal',
        'proceeding',
        'haki',
        'buku',
    ];
}
