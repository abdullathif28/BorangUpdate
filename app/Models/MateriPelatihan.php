<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriPelatihan extends Model
{
    use HasFactory;

    protected $table = 'materi_pelatihan';

    protected $fillable = [
        'pelatihan_id',
        'nama_materi',
        'urutan',
    ];

    public function pelatihan()
    {
        return $this->belongsTo(Pelatihan::class);
    }
}
