<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BahanBaku extends Model
{
    protected $fillable = [
        'nama',
        'stok',
        'harga',
        'supplier_id',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'stok' => 'integer',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function pembelianDetails()
    {
        return $this->hasMany(PembelianDetail::class, 'bahan_id');
    }
}
