<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pembelian;


class Supplier extends Model
{
    protected $fillable = [
        'nama',
        'alamat',
        'telp',
    ];

    public function pembelians()
    {
        return $this->hasMany(Pembelian::class);
    }
}
