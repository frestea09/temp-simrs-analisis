<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Registrasi\Entities\Registrasi;


class EmrFarmasi extends Model
{
    protected $table = 'emr_farmasi';
    Use SoftDeletes;

    public function registrasi(){
        return $this->belongsTo(Registrasi::class,'registrasi_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
