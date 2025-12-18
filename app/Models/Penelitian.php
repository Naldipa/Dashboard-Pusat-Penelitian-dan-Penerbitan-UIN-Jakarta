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
        //INSENTIF
        
        'nama_jurnal',
        'klaster',
        'biaya_insentif',
        //END INSENTIF
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
