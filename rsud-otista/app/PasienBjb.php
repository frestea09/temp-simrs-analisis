<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Modules\Registrasi\Entities\Registrasi;

class PasienBjb extends Model
{
    //
    protected $table = 'rs_mr';

    // public function registrasi(){
    //     return $this->hasOne(Registrasi::class,'id','registrasi_id');
    // }
}
