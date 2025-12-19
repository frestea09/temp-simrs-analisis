<?php

namespace App\Logistik;

use Illuminate\Database\Eloquent\Model;

class LogistikPenerimaan extends Model
{
    public function barang()
    {
        return $this->belongsTo(\App\Masterobat::class, 'masterobat_id', 'id');
    }   
}
