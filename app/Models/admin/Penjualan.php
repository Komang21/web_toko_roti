<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $fillable = [
        'tgl_jual',
        'total',
    ];

    protected $casts = [
        'tgl_jual' => 'datetime',
        'total' => 'decimal:2',
    ];

    public function details()
    {
        return $this->hasMany(PenjualanDetail::class);
    }
}
