<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_layanan',
        'jenis_kendaraan',
        'harga',
        'harga_motor',
        'harga_mobil',
        'durasi',
        'deskripsi',
        'status',
        'penjaga_id'
    ];

    /**
     * Get the penjaga that owns the layanan.
     */
    public function penjaga()
    {
        return $this->belongsTo(Penjaga::class);
    }

    /**
     * Get the transaksis for the layanan.
     */
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}
