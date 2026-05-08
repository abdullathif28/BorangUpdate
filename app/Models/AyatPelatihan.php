<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AyatPelatihan extends Model
{
    use HasFactory;

    protected $table = 'ayat_pelatihan';

    protected $fillable = [
        'pelatihan_id',
        'nama_ayat',
        'urutan',
    ];

    public function pelatihan()
    {
        return $this->belongsTo(Pelatihan::class);
    }

    public function hafalanNilai()
    {
        return $this->hasMany(HafalanNilai::class);
    }
}
