<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObservasiPendalaman extends Model
{
    use HasFactory;
    protected $table = 'observasi_pendalaman';  // Sesuaikan dengan nama tabel yang benar
    protected $fillable = [
        'materi_id',
        'peserta_id',
        'afektif',
        'kognitif',
        'psikomotorik',
        'jumlah',
    ];

    public function materi()
    {
        return $this->belongsTo(MateriPelatihan::class);
    }

    public function peserta()
    {
    return $this->belongsTo(Peserta::class, 'peserta_id'); // Sesuaikan dengan nama kolom yang sesuai
    }

    public function getNilaiAttribute()
    {
        return $this->afektif + $this->kognitif + $this->psikomotorik;
    }
}
