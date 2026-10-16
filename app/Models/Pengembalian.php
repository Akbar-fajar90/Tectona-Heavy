<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Pengembalian extends Model
{
    protected $fillable = [
        'peminjaman_id',
        'tanggal_pengembalian',
        'kondisi_saat_kembali',
        'catatan',
        'denda',
        'status',
        'verified_by',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pengembalian' => 'date',
            'denda'                => 'decimal:2',
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

    // =====================
    // SCOPE
    // =====================

    public function scopeProsesVerifikasi(Builder $query): Builder
    {
        return $query->where('status', 'proses_verifikasi');
    }

    public function scopeSelesai(Builder $query): Builder
    {
        return $query->where('status', 'selesai');
    }
}