<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookReference extends Model
{
    protected $fillable = [
        'judul',
        'penulis',
        'isbn',
        'e_isbn',
        'isbn_fk',
        'e_isbn_fk',
        'editor',
        'deskripsi',
        'tahun',
        'naskah_link',
        'cover',
        'jumlah_halaman',
        'status',
        'keterangan',
    ];
}
