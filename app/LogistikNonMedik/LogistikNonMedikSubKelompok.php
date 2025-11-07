<?php

namespace App\LogistikNonMedik;

use Illuminate\Database\Eloquent\Model;

class LogistikNonMedikSubKelompok extends Model
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
}
