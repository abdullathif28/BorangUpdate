<?php

namespace App\Models;

// Model ObservasiProses
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observasi_Proses extends Model
{
    use HasFactory;
    protected $table = 'observasi_proses';
    protected $fillable = [
        'peserta_id',
        'materi_id',
        'afektif',
        'psikomotorik',
        'kognitif',
        'pelatihan_id',
        'rata_rata', // <--- Tambahkan ini
   
    ];

    public function pelatihan()
    {
        return $this->belongsTo(Pelatihan::class); // Relasi dengan model Pelatihan
    }

    public function peserta()
    {
        return $this->belongsTo(Peserta::class); // Relasi dengan model Peserta
    }

    public function materi()
    {
        return $this->belongsTo(MateriPelatihan::class); // Relasi dengan model MateriPelatihan
    }
}
