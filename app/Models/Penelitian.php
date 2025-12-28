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
        'id_register',
        'penulis_utama',
        'anggota_penulis',
        'penulis_dua',
        'penulis_tiga',
        'nama_jurnal',
        'klaster',
        'biaya_insentif',
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
