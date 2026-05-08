<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasca extends Model
{
    use HasFactory;

    protected $table = 'observasi_pasca';

    protected $fillable = [
        'peserta_id',
        'materi_id',
        'afektif',
        'psikomotorik',
        'kognitif', 
        'rata_rata', // <--- Tambahkan ini

    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    public function materi()
    {
        return $this->belongsTo(MateriPelatihan::class);
    }
}
