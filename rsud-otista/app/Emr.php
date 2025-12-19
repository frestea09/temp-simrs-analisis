<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Modules\Registrasi\Entities\Registrasi;
use Illuminate\Database\Eloquent\SoftDeletes;

class Emr extends Model
{
    //
    protected $table = 'emr';
    Use SoftDeletes;
    
    public function registrasi(){
        return $this->hasOne(Registrasi::class,'id','registrasi_id');
    }

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function emrPenilaian(){
        return $this->hasOne(EmrInapPenilaian::class, 'cppt_id', 'id');
    }
}
