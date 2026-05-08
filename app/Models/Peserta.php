<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;

    protected $table = 'peserta';

    protected $fillable = [
        'nama', 'asal_pimpinan', 'alamat', 'ttl', 'jenis_kelamin',
        'nomor_hp', 'moto_hidup', 'pelatihan_id', 'pretest', 'posttest',
    ];

    public function hafalanNilai()
    {
        return $this->hasMany(HafalanNilai::class, 'peserta_id');
    }

    // Keep backward compat — old hafalan relation (deprecated)
    public function hafalan()
    {
        return $this->hasOne(Hafalan::class, 'peserta_id');
    }

    public function kultum()
    {
        return $this->hasMany(Kultum::class, 'id_peserta');
    }

    public function observasiProses()
    {
        return $this->hasMany(Observasi_Proses::class);
    }

    public function observasiPendalaman()
    {
        return $this->hasMany(ObservasiPendalaman::class, 'peserta_id', 'id');
    }

    public function observasiImamah()
    {
        return $this->hasMany(Observasi_Imamah_kajian::class);
    }

    public function observasiGames()
    {
        return $this->hasMany(Observasi_games::class);
    }

    public function pelatihan()
    {
        return $this->belongsTo(Pelatihan::class);
    }

    // ===== NILAI HELPERS =====
    public function observasiProsesAverage()
    {
        $materi = $this->observasiProses()->get();
        if ($materi->isEmpty()) return null;
        $total = $materi->sum(fn($item) => $item->afektif + $item->kognitif + $item->psikomotorik);
        return round($total / $materi->count(), 2);
    }

    public function observasiPendalamanAverage()
    {
        $materi = $this->observasiPendalaman()->get();
        if ($materi->isEmpty()) return null;
        return round($materi->sum(fn($m) => $m->nilai) / $materi->count(), 2);
    }

    public function observasiImamahAverage()
    {
        $materi = $this->observasiImamah()->get();
        if ($materi->isEmpty()) return null;
        return round($materi->sum(fn($m) => $m->nilai) / $materi->count(), 2);
    }

    public function observasiGamesAverage()
    {
        $materi = $this->observasiGames()->get();
        if ($materi->isEmpty()) return null;
        return round($materi->sum(fn($m) => $m->nilai) / $materi->count(), 2);
    }

    public function kultumAverage()
    {
        if ($this->kultum->isEmpty()) return null;
        $k = $this->kultum->first();
        return round(($k->penguasaan_materi + $k->kesesuaian_tema + $k->kefasihan + $k->adab_sikap + $k->daya_tarik) / 5, 1);
    }

    /**
     * Hafalan score normalized to 100 points
     */
    public function hafalanScore(): float
    {
        $nilai = $this->hafalanNilai;
        if ($nilai->isEmpty()) return 0;
        return round($nilai->sum('nilai'), 2);
    }

    public function totalRaportScore()
    {
    $components = [
        'pretest'     => $this->pretest,
        'posttest'    => $this->posttest,
        'hafalan'     => $this->hafalanNilai->isEmpty() ? null : $this->hafalanScore(),
        'obs_proses'  => $this->observasiProses->isEmpty() ? null : $this->observasiProsesAverage(),
        'pendalaman'  => $this->observasiPendalaman->isEmpty() ? null : $this->observasiPendalamanAverage(),
        'imamah'      => $this->observasiImamah->isEmpty() ? null : $this->observasiImamahAverage(),
        'games'       => $this->observasiGames->isEmpty() ? null : $this->observasiGamesAverage(),
        'kultum'      => $this->kultum->isEmpty() ? null : $this->kultumAverage(),
    ];

    $assessed = array_filter($components, fn($v) => !is_null($v));

    if (empty($assessed)) return 0;

    return round(array_sum($assessed), 2);
    }

    public function averageRaportScore()
    {
        // Only count components that have data entered (null = not yet assessed, 0 = assessed as zero)
        $components = [
            'pretest'     => $this->pretest,
            'posttest'    => $this->posttest,
            'hafalan'     => $this->hafalanNilai->isEmpty() ? null : $this->hafalanScore(),
            'obs_proses'  => $this->observasiProses->isEmpty() ? null : $this->observasiProsesAverage(),
            'pendalaman'  => $this->observasiPendalaman->isEmpty() ? null : $this->observasiPendalamanAverage(),
            'imamah'      => $this->observasiImamah->isEmpty() ? null : $this->observasiImamahAverage(),
            'games'       => $this->observasiGames->isEmpty() ? null : $this->observasiGamesAverage(),
            'kultum'      => $this->kultum->isEmpty() ? null : $this->kultumAverage(),
        ];

        // Filter out null (not yet assessed) — keep 0 scores as valid
        $assessed = array_filter($components, fn($v) => !is_null($v));

        if (empty($assessed)) return 0;
        return round(array_sum($assessed) / count($assessed), 2);
    }

    public function predikatRaport()
    {
        $nilai = $this->averageRaportScore();
        if ($nilai >= 90) return 'A';
        if ($nilai >= 80) return 'B';
        if ($nilai >= 70) return 'C';
        if ($nilai >= 60) return 'D';
        return 'E';
    }

    public function keteranganBimbingan()
    {
        return match($this->predikatRaport()) {
            'A' => 'Sangat Baik',
            'B' => 'Baik',
            'C' => 'Cukup',
            'D' => 'Perlu Bimbingan',
            default => 'Perlu Bimbingan Intensif',
        };
    }
}
