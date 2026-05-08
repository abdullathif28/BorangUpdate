<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notulensi extends Model
{
    use HasFactory;
    protected $table = 'notulensi';
    protected $fillable = [
        'pelatihan_id',
        'materi_id',
        'pengampu',
        'moderator',
        'notulis',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'jumlah_peserta',
        'kondisi_peserta',
        'pokok_materi',
        'jalannya_materi',
        'pokok_pembahasan',
    ];

    /**
     * Relasi ke Pelatihan
     */
    // app/Models/Notulensi.php

public function pelatihan()
{
    return $this->belongsTo(Pelatihan::class);
}

public function materi()
{
    return $this->belongsTo(MateriPelatihan::class, 'materi_id');
}

public function notulensi_pertanyaan()
{
    return $this->hasMany(NotulensiPertanyaan::class);
}

    
}
