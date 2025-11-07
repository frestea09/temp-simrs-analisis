<?php

namespace App\LogistikNonMedik;

use Illuminate\Database\Eloquent\Model;

class LogistikNonMedikPo extends Model
{
    public function barang()
    {
        return $this->belongsTo(\App\LogistikNonMedik\LogistikNonMedikBarang::class, 'masterbarang_id', 'id');
    }

    public function bacasatuan()
    {
        return $this->belongsTo(\App\LogistikNonMedik\LogistikNonMedikSatuan::class, 'satuan', 'id');
    }
}
