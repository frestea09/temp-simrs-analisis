<?php

namespace App\LogistikNonMedik;

use Illuminate\Database\Eloquent\Model;

class LogistikNonMedikBidang extends Model
{
    public function golongan()
    {
        return $this->belongsTo('\App\LogistikNonMedik\LogistikNonMedikGolongan', 'golongan_id', 'id');
    }
}
