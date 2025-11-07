<?php

namespace App\LogistikNonMedik;

use Illuminate\Database\Eloquent\Model;

class LogistikNonMedikKelompok extends Model
{
    public function golongan()
    {
        return $this->belongsTo('\App\LogistikNonMedik\LogistikNonMedikGolongan', 'golongan_id', 'id');
    }
    public function bidang()
    {
        return $this->belongsTo('\App\LogistikNonMedik\LogistikNonMedikBidang', 'bidang_id', 'id');
    }
}
