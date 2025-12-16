<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penelitian extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'fakultas',
        'penulis_utama',
        'anggota_penulis',
        'tahun',
        'status',
        'abstrak',
        'file_path',
    ];
}