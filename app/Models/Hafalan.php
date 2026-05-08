<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Legacy Hafalan model — kept for backward compatibility.
 * New system uses HafalanNilai + AyatPelatihan instead.
 */
class Hafalan extends Model
{
    use HasFactory;

    protected $table = 'hafalan';

    protected $fillable = [
        'peserta_id',
        'surat_1', 'surat_2', 'surat_3', 'surat_4',
        'surat_5', 'surat_6', 'surat_7',
        'nilai',
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }
}
