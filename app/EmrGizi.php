<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Kamar\Entities\Kamar;
use Modules\Registrasi\Entities\Registrasi;


class EmrGizi extends Model
{
    protected $table = 'emr_gizi';
    Use SoftDeletes;

    public function registrasi(){
        return $this->belongsTo(Registrasi::class,'registrasi_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function kamar(){
        return $this->belongsTo(Kamar::class, 'kamar_id', 'id');
    }
}
