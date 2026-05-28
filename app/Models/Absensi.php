<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';

    protected $fillable = [
        'peserta_id',
        'materi_id',
        'kategori',
        'hadir',
        'peserta_nama',
    ];

    // Relasi ke Peserta
    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    // Relasi ke Materi
    public function materi()
    {
        return $this->belongsTo(MateriPelatihan::class);
    }
}
