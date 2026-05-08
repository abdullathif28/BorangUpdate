<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FgdPelatihan extends Model
{
    use HasFactory;

    protected $table = 'fgd_pelatihan'; // <- Ini WAJIB supaya Laravel pakai nama tabel yang benar
    protected $fillable = ['pelatihan_id', 'nama_fgd'];

    public function pelatihan()
    {
        return $this->belongsTo(Pelatihan::class);
    }
}
