<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\PenjualanDetail;

class Produk extends Model
{
    protected $fillable = [
        'nama',
        'harga_jual',
        'stok',
    ];

    protected $casts = [
        'harga_jual' => 'decimal:2',
        'stok' => 'integer',
    ];

    public function penjualanDetails()
    {
        return $this->hasMany(\App\Models\admin\PenjualanDetail::class, 'produk_id');
    }
}
