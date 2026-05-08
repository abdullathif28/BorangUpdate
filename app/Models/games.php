<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class games extends Model
{
    use HasFactory;

    protected $table = 'games';

    protected $fillable = [
        'pelatihan_id',
        'nama_games',
        'urutan',
    ];

    public function pelatihan()
    {
        return $this->belongsTo(Pelatihan::class);
    }
}
