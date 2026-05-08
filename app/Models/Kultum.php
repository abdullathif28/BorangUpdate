<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kultum extends Model
{
    use HasFactory;

    protected $table = 'kultum';

    protected $fillable = [
        'id_peserta',
        'penguasaan_materi',
        'kesesuaian_tema',
        'kefasihan',
        'adab_sikap',
        'daya_tarik',
        'nilai',
    ];
    

    /**
     * Relasi ke model Peserta.
     */
    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta');
    }

    /**
     * Menghitung nilai total dari seluruh aspek penilaian.
     */
    public function getTotalNilaiAttribute()
    {
        return $this->penguasaan_materi +
               $this->kesesuaian_tema +
               $this->kefasihan +
               $this->adab_sikap +
               $this->daya_tarik;
    }
}
