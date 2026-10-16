<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;


#[Fillable(['name', 'email', 'email_verified_at', 'password', 'role', 'no_telp', 'alamat'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function peminjamans(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'user_id');
    }

    public function approvedPeminjamans(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'approved_by');
    }

    public function verifiedPengembalians(): HasMany
    {
        return $this->hasMany(Pengembalian::class, 'verified_by');
    }

    public function verifiedPembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran::class, 'verified_by');
    }


       public function scopeAdmin(Builder $query): Builder
    {
        return $query->where('role', 'admin');
    }

    public function scopePetugas(Builder $query): Builder
    {
        return $query->where('role', 'petugas');
    }

    public function scopePeminjam(Builder $query): Builder
    {
        return $query->where('role', 'peminjam');
    }


        public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPetugas(): bool
    {
        return $this->role === 'petugas';
    }

    public function isPeminjam(): bool
    {
        return $this->role === 'peminjam';
    }
    
}
