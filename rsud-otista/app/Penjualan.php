<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Apoteker;
use Illuminate\Support\Facades\DB;
use Modules\Registrasi\Entities\Registrasi;

class Penjualan extends Model
{
    public function apoteker()
    {
        return $this->belongsTo(Apoteker::class);
    }

    public function registrasi()
    {
        return $this->hasOne(Registrasi::class,'id','registrasi_id');
    }

    public function penjualandetail(){
        return $this->hasMany(Penjualandetail::class,'penjualan_id','id');
    }

    public function eresep(){
        return $this->hasMany(ResepNote::class, 'penjualan_id', 'id');
    }

}
