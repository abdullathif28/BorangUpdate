<?php

namespace App\Traits;

use App\Models\Pelatihan;
use App\Models\Peserta;
use App\Models\MateriPelatihan;
use App\Models\Imamah_kajian;
use App\Models\games;
use App\Models\AyatPelatihan;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;

trait PelatihanContext
{
    /**
     * Get the currently active pelatihan_id for the logged-in user.
     * 
     * Priority:
     * 1. Sub-role: use their assigned pelatihan_id
     * 2. Session pelatihan_aktif_id
     * 3. Fallback: latest aktif pelatihan of admin
     */
    protected function getActivePelatihanId(): ?int
    {
        $user = Auth::user();

        // Sub-role: always uses assigned pelatihan
        if ($user->isSubRole()) {
            return $user->pelatihan_id;
        }

        // Check session
        $sessionId = session('pelatihan_aktif_id');
        if ($sessionId) {
            // Verify this pelatihan belongs to this admin (or superadmin can access all)
            if ($user->isSuperadmin()) {
                return $sessionId;
            }
            $exists = Pelatihan::where('id', $sessionId)->where('admin_id', $user->id)->exists();
            if ($exists) {
                return $sessionId;
            }
        }

        // Fallback: latest aktif pelatihan for this admin
        if ($user->isAdmin()) {
            $pelatihan = Pelatihan::where('admin_id', $user->id)
                ->where('status', 'aktif')
                ->latest()
                ->first();
            if ($pelatihan) {
                session(['pelatihan_aktif_id' => $pelatihan->id]);
                return $pelatihan->id;
            }
        }

        // Superadmin fallback: latest aktif globally
        if ($user->isSuperadmin()) {
            $pelatihan = Pelatihan::where('status', 'aktif')->latest()->first();
            if ($pelatihan) {
                session(['pelatihan_aktif_id' => $pelatihan->id]);
                return $pelatihan->id;
            }
        }

        return null;
    }

    /**
     * Get the active Pelatihan model
     */
    protected function getActivePelatihan(): ?Pelatihan
    {
        $id = $this->getActivePelatihanId();
        return $id ? Pelatihan::find($id) : null;
    }

    /**
     * Get admin_id for data scoping
     */
    protected function getScopedAdminId(): ?int
    {
        $user = Auth::user();
        if ($user->isSuperadmin()) {
            // Superadmin: scope to the active pelatihan's admin
            $pelatihan = $this->getActivePelatihan();
            return $pelatihan?->admin_id;
        }
        if ($user->isSubRole()) {
            return $user->admin_id;
        }
        return $user->id;
    }

    /**
     * Get peserta filtered by active pelatihan
     */
    protected function getPesertaForActivePelatihan()
    {
        $pelatihanId = $this->getActivePelatihanId();
        if (!$pelatihanId) {
            return collect();
        }
        return Peserta::where('pelatihan_id', $pelatihanId)->get();
    }

    /**
     * Get materi filtered by active pelatihan
     */
    protected function getMateriForActivePelatihan()
    {
        $pelatihanId = $this->getActivePelatihanId();
        if (!$pelatihanId) {
            return collect();
        }
        return MateriPelatihan::where('pelatihan_id', $pelatihanId)->get();
    }

    /**
     * Get imamah/kajian filtered by active pelatihan
     */
    protected function getImamahForActivePelatihan()
    {
        $pelatihanId = $this->getActivePelatihanId();
        if (!$pelatihanId) {
            return collect();
        }
        return Imamah_kajian::where('pelatihan_id', $pelatihanId)->get();
    }

    /**
     * Get games filtered by active pelatihan
     */
    protected function getGamesForActivePelatihan()
    {
        $pelatihanId = $this->getActivePelatihanId();
        if (!$pelatihanId) {
            return collect();
        }
        return games::where('pelatihan_id', $pelatihanId)->get();
    }

    /**
     * Get ayat pelatihan filtered by active pelatihan
     */
    protected function getAyatForActivePelatihan()
    {
        $pelatihanId = $this->getActivePelatihanId();
        if (!$pelatihanId) {
            return collect();
        }
        return AyatPelatihan::where('pelatihan_id', $pelatihanId)->orderBy('urutan')->get();
    }

    /**
     * Get list of pelatihan user can access (for selectors)
     */
    protected function getAccessiblePelatihan()
    {
        $user = Auth::user();

        if ($user->isSuperadmin()) {
            return Pelatihan::with('admin')->latest()->get();
        }

        if ($user->isAdmin()) {
            return Pelatihan::where('admin_id', $user->id)->latest()->get();
        }

        // Sub-role: only their assigned pelatihan
        if ($user->isSubRole() && $user->pelatihan_id) {
            return Pelatihan::where('id', $user->pelatihan_id)->get();
        }

        return collect();
    }
}
