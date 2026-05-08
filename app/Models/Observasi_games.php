<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observasi_games extends Model
{
    //
    use HasFactory;
    protected $table = 'observasi_games';  // Sesuaikan dengan nama tabel yang benar
    protected $fillable = [
        'games_id',
        'peserta_id',
        'afektif',
        'kognitif',
        'psikomotorik',
        'jumlah',
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }
    public function getNilaiAttribute()
    {
        return $this->afektif + $this->kognitif + $this->psikomotorik;
    }
}
