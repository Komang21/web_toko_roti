<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pembelian;
use App\Models\BahanBaku;

class PembelianDetail extends Model
{
    protected $fillable = [
        'pembelian_id',
        'bahan_id',
        'qty',
        'harga',
        'subtotal',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class);
    }

    public function bahan()
    {
        return $this->belongsTo(BahanBaku::class, 'bahan_id');
    }
}
?>

