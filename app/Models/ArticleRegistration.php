<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleRegistration extends Model
{
    protected $fillable = [
        'nama',
        'fakultas',
        'judul',
        'jumlah_rp',
    ];
}
