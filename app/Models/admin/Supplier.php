<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\admin\Pembelian;


class Supplier extends Model
{
    protected $fillable = [
        'nama',
        'alamat',
        'telp',
    ];

    public function pembelians()
    {
return $this->hasMany(\App\Models\admin\Pembelian::class);
    }
}
