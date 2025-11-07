<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\KlasifikasiPengeluaran;
use App\JenisPengeluaran;
use App\Satuanbeli;
class TransaksiKeluar extends Model
{
    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
    
    public function klasifikasi()
    {
        return $this->hasOne(KlasifikasiPengeluaran::class,'id','klasifikasi_pengeluaran_id');
    }
    
    public function jenis()
    {
        return $this->hasOne(JenisPengeluaran::class,'id','jenis_pengeluaran_id');
    }

    public function satuanbeli()
    {
        return $this->hasOne(Satuanbeli::class,'id','satuanbeli_id');
    }
}
