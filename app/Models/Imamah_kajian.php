<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imamah_kajian extends Model
{
    use HasFactory;

    protected $table = 'imamah_kajian';

    protected $fillable = [
        'pelatihan_id',
        'nama_kajian',
        'urutan',
    ];

    public function pelatihan()
    {
        return $this->belongsTo(Pelatihan::class);
    }
}