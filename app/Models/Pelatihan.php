<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelatihan extends Model
{
    use HasFactory;

    protected $table = 'pelatihan';
    protected $fillable = [
        'admin_id', 'status', 'catatan_superadmin', 'token_pendaftaran',
        'nama_lfp', 'email_lfp', 'nama_mot', 'nba_mot', 'nama_asisten_mot', 'hp_asisten_mot',
        'nama_pelatihan', 'penyelenggara', 'nama_ketum', 'nba_ketum', 'tanggal_pelatihan', 'tempat_pelatihan',
        'jumlah_materi', 'jumlah_fgd', 'jumlah_hafalan', 'jumlah_kajian', 'jumlah_games',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function materi()
    {
        return $this->hasMany(MateriPelatihan::class);
    }

    public function fgd()
    {
        return $this->hasMany(FgdPelatihan::class);
    }

    public function materipelatihan()
    {
        return $this->hasMany(MateriPelatihan::class);
    }

    public function observasiPendalaman()
    {
        return $this->hasMany(ObservasiPendalaman::class);
    }

    public function pesertas()
    {
        return $this->hasMany(Peserta::class);
    }

    public function imamahKajian()
    {
        return $this->hasMany(Imamah_kajian::class);
    }

    public function games()
    {
        return $this->hasMany(games::class);
    }

    public function ayatPelatihan()
    {
        return $this->hasMany(AyatPelatihan::class);
    }

    public function subRoles()
    {
        return $this->hasMany(User::class, 'pelatihan_id');
    }

    // Status helpers
    public function isPending(): bool  { return $this->status === 'pending'; }
    public function isAktif(): bool    { return $this->status === 'aktif'; }
    public function isSelesai(): bool  { return $this->status === 'selesai'; }
    public function isDitolak(): bool  { return $this->status === 'ditolak'; }

    public function getStatusBadge(): string
    {
        return match($this->status) {
            'pending'  => '<span class="badge bg-warning text-dark">Menunggu Konfirmasi</span>',
            'aktif'    => '<span class="badge bg-success">Aktif</span>',
            'selesai'  => '<span class="badge bg-secondary">Selesai</span>',
            'ditolak'  => '<span class="badge bg-danger">Ditolak</span>',
            default    => '<span class="badge bg-light">-</span>',
        };
    }

    /**
     * Generate unique token pendaftaran
     */
    public static function generateToken(): string
    {
        $attempts = 0;
        do {
            if (++$attempts > 20) {
                // Extremely unlikely but prevent theoretical infinite loop
                $token = strtoupper(\Illuminate\Support\Str::random(12));
                break;
            }
            $token = strtoupper(\Illuminate\Support\Str::random(8));
        } while (self::where('token_pendaftaran', $token)->exists());

        return $token;
    }
}
