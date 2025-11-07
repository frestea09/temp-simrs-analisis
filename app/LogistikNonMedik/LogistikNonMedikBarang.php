<?php

namespace App\LogistikNonMedik;

use Illuminate\Database\Eloquent\Model;

class LogistikNonMedikBarang extends Model
{
    public function golongan()
    {
        return $this->belongsTo('\App\LogistikNonMedik\LogistikNonMedikGolongan', 'golongan_id', 'id');
    }
    public function bidang()
    {
        return $this->belongsTo('\App\LogistikNonMedik\LogistikNonMedikBidang', 'bidang_id', 'id');
    }
    public function kelompok()
    {
        return $this->belongsTo('\App\LogistikNonMedik\LogistikNonMedikKelompok', 'kelompok_id', 'id');
    }
    public function subkelompok()
    {
        return $this->belongsTo('\App\LogistikNonMedik\LogistikNonMedikSubKelompok', 'sub_kelompok_id', 'id');
    }
    public function supplier()
    {
        return $this->belongsTo('\App\LogistikNonMedik\LogistikNonMedikSuplier', 'supplier_id', 'id');
    }
}
