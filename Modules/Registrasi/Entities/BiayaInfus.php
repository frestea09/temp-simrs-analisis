<?php

namespace Modules\Registrasi\Entities;
use Modules\Tarif\Entities\Tarif;
use Illuminate\Database\Eloquent\Model;

class BiayaInfus extends Model
{
    protected $table = 'biaya_infus';
    protected $fillable = ['nama_biaya'];
    //
    public function detail()
    {
        return $this->hasMany(BiayaInfusDetail::class, 'biaya_infus_id', 'id');
    }
}
