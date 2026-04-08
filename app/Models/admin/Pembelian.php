<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\PembelianDetail;
use App\Models\Supplier;

class Pembelian extends Model
{
    protected $fillable = [
        'tgl_pembelian',
        'total',
        'supplier_id',
    ];

    protected $casts = [
        'tgl_pembelian' => 'datetime',
        'total' => 'decimal:2',
    ];

    public function supplier()
    {
        return $this->belongsTo(\App\Models\admin\Supplier::class);
    }

    public function details()
    {
        return $this->hasMany(PembelianDetail::class);
    }
}
