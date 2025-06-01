<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanPembayaran extends Model
{
    use HasFactory;

    protected $table = 'catatan_pembayaran';

    protected $fillable = [
        'transaksi_id',
        'penjaga_id',
        'nominal',
        'tanggal',
        'keterangan',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function penjaga()
    {
        return $this->belongsTo(Penjaga::class);
    }
} 