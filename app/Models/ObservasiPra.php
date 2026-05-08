<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObservasiPra extends Model
{
    protected $table = 'observasi_pra';
    protected $fillable = ['peserta_id', 'materi_id', 'afektif', 'psikomotorik', 'kognitif', 'rata_rata'];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    public function materi()
    {
        return $this->belongsTo(MateriPelatihan::class, 'materi_id');
    }
} 
