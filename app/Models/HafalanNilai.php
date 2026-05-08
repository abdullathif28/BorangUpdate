<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HafalanNilai extends Model
{
    use HasFactory;

    protected $table = 'hafalan_nilai';

    protected $fillable = [
        'peserta_id',
        'ayat_pelatihan_id',
        'hafal',
        'nilai',
    ];

    protected $casts = [
        'hafal' => 'boolean',
        'nilai' => 'decimal:2',
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    public function ayatPelatihan()
    {
        return $this->belongsTo(AyatPelatihan::class);
    }
}
