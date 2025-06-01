<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'pelanggan_id',
        'layanan_id',
        'kendaraan_id',
        'jumlah_pembayaran',
        'total',
        'durasi_penitipan',
        'status',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(\App\Models\Pelanggan::class, 'pelanggan_id');
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }
    
    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function catatanPembayaran()
    {
        return $this->hasMany(\App\Models\CatatanPembayaran::class, 'transaksi_id');
    }

}
