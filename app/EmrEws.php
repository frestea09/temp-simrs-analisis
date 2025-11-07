<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Registrasi\Entities\Registrasi;
// use Illuminate\Database\Eloquent\SoftDeletes;

class EmrEws extends Model
{
    use SoftDeletes;

    public function registrasi(){
        return $this->hasOne(Registrasi::class,'id','registrasi_id');
    }
}
