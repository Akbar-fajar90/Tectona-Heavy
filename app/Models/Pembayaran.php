<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Pembayaran extends Model
{
    protected $fillable = [
        'peminjaman_id',
        'jenis_pembayaran',
        'angsuran_ke',
        'jumlah_bayar',
        'tanggal_bayar',
        'metode_bayar',
        'bukti_bayar',
        'status',
        'verified_by',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_bayar' => 'date',
            'jumlah_bayar'  => 'decimal:2',
            'angsuran_ke'   => 'integer',
        ];
    }

    // =====================
    // RELASI
    // =====================

    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id');
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function jadwalPembayarans(): HasMany
    {
        return $this->hasMany(JadwalPembayaran::class, 'pembayaran_id');
    }

    // =====================
    // SCOPE
    // =====================

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function scopeTerverifikasi(Builder $query): Builder
    {
        return $query->where('status', 'terverifikasi');
    }
}