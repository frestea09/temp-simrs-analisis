<?php

namespace Modules\Registrasi\Entities;
use Modules\Tarif\Entities\Tarif;
use Illuminate\Database\Eloquent\Model;

class BiayaMcu extends Model
{
    protected $table = 'biaya_mcu';
    protected $fillable = ['nama_biaya'];
    //
    public function detail()
    {
        return $this->hasMany(BiayaMcuDetail::class, 'biaya_mcu_id', 'id');
    }
}
