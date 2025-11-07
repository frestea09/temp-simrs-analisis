<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Modules\Pasien\Entities\Pasien;
use Modules\Registrasi\Entities\Registrasi;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hasillab extends Model
{
    use SoftDeletes;
    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function lis(){
        return $this->hasOne(LisResult::class,'no_ref','no_lab');
    }

    public function orderLab(){
        return $this->belongsTo(Orderlab::class);
    }

    public function registrasi(){
        return $this->belongsTo(Registrasi::class);
    }

    public function rincianHasilLab()
    {
        return $this->hasMany(RincianHasillab::class, 'hasillab_id', 'id');
    }
}
