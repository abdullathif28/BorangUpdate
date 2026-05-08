<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotulensiPertanyaan extends Model
{
    use HasFactory;
    protected $table = 'notulensi_pertanyaan';
    protected $fillable = [
        'notulensi_id',
        'pertanyaan',
        'jawaban',
    ];

    /**
     * Relasi ke Notulensi
     */
    public function notulensi()
    {
        return $this->belongsTo(Notulensi::class);
    }
}
