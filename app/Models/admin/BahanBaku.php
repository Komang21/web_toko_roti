<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class BahanBaku extends Model
{

protected $table = 'bahan_bakus';

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
return $this->belongsTo(\App\Models\admin\Supplier::class);
    }

    public function pembelianDetails()
    {
        return $this->hasMany(\App\Models\admin\PembelianDetail::class, 'bahan_id');
    }
}
