<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penelitian extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'fakultas_id',
        'fakultas',
        'penulis_utama',
        'anggota_penulis',
        'tahun',
        'status',
        'abstrak',
        'file_path',
    ];

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class);
    }
}
