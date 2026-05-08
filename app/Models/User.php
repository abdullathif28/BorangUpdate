<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'username', 'firstname', 'lastname', 'name', 'email', 'password',
        'address', 'city', 'country', 'postal', 'about',
        'role', 'nama_pimpinan', 'tingkat_pimpinan', 'nama_ketum',
        'nomor_hp', 'jumlah_cabang', 'status', 'catatan_penolakan',
        'admin_id', 'token_login', 'pelatihan_id',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime'];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function isSuperadmin(): bool { return $this->role === 'superadmin'; }
    public function isAdmin(): bool      { return $this->role === 'admin'; }
    public function isIOT(): bool        { return $this->role === 'iot'; }
    public function isMOG(): bool        { return $this->role === 'mog'; }
    public function isObserver(): bool   { return $this->role === 'observer'; }
    public function isSubRole(): bool    { return in_array($this->role, ['iot', 'mog', 'observer']); }
    public function isApproved(): bool   { return $this->status === 'approved'; }

    public function getRoleLabel(): string
    {
        return match($this->role) {
            'superadmin' => 'Super Admin',
            'admin'      => 'Admin',
            'iot'        => 'Imam of Trainer (IOT)',
            'mog'        => 'Master of Games (MOG)',
            'observer'   => 'Observer',
            default      => ucfirst($this->role),
        };
    }

    public function subRoles()
    {
        return $this->hasMany(User::class, 'admin_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function pelatihan()
    {
        return $this->hasMany(Pelatihan::class, 'admin_id');
    }

    /**
     * Pelatihan yang ditugaskan untuk sub-role
     */
    public function pelatihanTugas()
    {
        return $this->belongsTo(Pelatihan::class, 'pelatihan_id');
    }

    /**
     * Get admin_id — for sub-role returns their admin_id, for admin returns own id
     */
    public function getEffectiveAdminId(): ?int
    {
        if ($this->isSubRole()) {
            return $this->admin_id; // could be null if sub-role somehow has no admin
        }
        return $this->id;
    }

    /**
     * Get pelatihan_id — for sub-role returns their assigned pelatihan, for admin returns null (must select)
     */
    public function getEffectivePelatihanId(): ?int
    {
        if ($this->isSubRole()) {
            return $this->pelatihan_id;
        }
        return null;
    }
}
