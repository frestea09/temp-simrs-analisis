<?php

namespace App\Logistik;

use Illuminate\Database\Eloquent\Model;

class LogistikPermintaan extends Model
{
    public function barang()
    {
        return $this->belongsTo(\App\Masterobat::class, 'masterobat_id', 'id');
    }

    public function gudang()
    {
        return $this->belongsTo(\App\Logistik\LogistikGudang::class, 'gudang_asal', 'id');
    }

    public function gudangTujuan()
    {
        return $this->belongsTo(\App\Logistik\LogistikGudang::class, 'gudang_tujuan', 'id');
    } 
}
