<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Penjualan;
use App\Models\Produk;

class PenjualanDetail extends Model
{
    protected $fillable = [
        'penjualan_id',
        'produk_id',
        'qty',
        'harga',
        'subtotal',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
?>

