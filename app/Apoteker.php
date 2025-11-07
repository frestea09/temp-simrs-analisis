<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Penjualan;

class Apoteker extends Model
{
    public function penjualan()
    {
        return $this->hasMany(Penjualan::class);
    }
}
