<?php

namespace Modules\Registrasi\Entities;
use Modules\Tarif\Entities\Tarif;
use Illuminate\Database\Eloquent\Model;

class BiayaInfusDetail extends Model
{
    protected $table = 'biaya_infus_detail';
    protected $fillable = ['biaya_infus_id','tarif_id'];
    //
    public function tarif()
    {
        return $this->belongsTo(Tarif::class);
    }
}
