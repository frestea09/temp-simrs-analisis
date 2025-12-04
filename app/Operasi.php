<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Modules\Registrasi\Entities\Registrasi;
use App\Rawatinap;

class Operasi extends Model
{
    //
    public function registrasi(){
        return $this->hasOne(Registrasi::class,'id','registrasi_id');
    }

    public function rawatinap()
    {
        return $this->hasOne(Rawatinap::class, 'registrasi_id', 'registrasi_id');
    }

    public function getRegistrasiRanapAttribute()
    {
        $registrasiAwal = $this->registrasi;

        if (! $registrasiAwal) {
            return null;
        }

        return Registrasi::where('pasien_id', $registrasiAwal->pasien_id)
            ->where('input_from', 'registrasi-ranap-langsung')
            ->orderBy('created_at', 'DESC')
            ->whereNull('deleted_at')
            ->first();
    }

    public function getRawatinapDariRegistrasiRanapAttribute()
    {
        $registrasiRanap = $this->registrasi_ranap;

        if (! $registrasiRanap) {
            return null;
        }

        return Rawatinap::where('registrasi_id', $registrasiRanap->id)->first();
    }


}