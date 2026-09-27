<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Override;

class Product extends Model
{
    protected $fillable = [
        'gambar',
        'kode_produk',
        'nama_produk',
        'deskripsi',
        'kategori',
        'harga',
        'stok'
    ];

    #[Override]
    protected static function booted()
    {
        static::creating(function($produk) {
            do {
                $code = 'PRD-' . Str::upper(Str::random(4));
            } while (self::where('kode_produk', $code)->exists());

            $produk->kode_produk = $code;
        });
    }

    #[Override]
    public function getRouteKeyName()
    {
        return 'kode_produk';
    }
}
