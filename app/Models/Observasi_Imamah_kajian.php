<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observasi_Imamah_kajian extends Model
{
    use HasFactory;
    protected $table = 'observasi_imamah_kajian';  // Sesuaikan dengan nama tabel yang benar
    protected $fillable = [
        'imamah_id',
        'peserta_id',
        'afektif',
        'kognitif',
        'psikomotorik',
        'jumlah',
    ];

    public function materi()
    {
        return $this->belongsTo(Imamah_kajian::class);
    }

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }
    public function getNilaiAttribute()
    {
        return $this->afektif + $this->kognitif + $this->psikomotorik;
    }
}
