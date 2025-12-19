<?php

namespace Modules\Registrasi\Entities;
use Modules\Tarif\Entities\Tarif;
use Illuminate\Database\Eloquent\Model;

class BiayaMcuDetail extends Model
{
    protected $table = 'biaya_mcu_detail';
    protected $fillable = ['biaya_mcu_id','tarif_id'];
    //
    public function tarif()
    {
        return $this->belongsTo(Tarif::class);
    }
}
