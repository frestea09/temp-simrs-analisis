<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Registrasi\Entities\Registrasi;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmrPengkajianHarian extends Model
{
    //
    use SoftDeletes;

    

    public function registrasi(){
        return $this->hasOne(Registrasi::class,'id','registrasi_id');
    }

    public function dokter(){
        return $this->hasOne(Pegawai::class,'id','dokter_id');
    }
}
