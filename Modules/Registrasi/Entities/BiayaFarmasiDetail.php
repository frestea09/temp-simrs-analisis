<?php

namespace Modules\Registrasi\Entities;
use \App\Masterobat;
use Illuminate\Database\Eloquent\Model;

class BiayaFarmasiDetail extends Model
{
    protected $table = 'biaya_farmasi_detail';
    protected $fillable = ['biaya_farmasi_id','masterobat_id'];
    //
    public function masterobat()
    {
        return $this->belongsTo(Masterobat::class, 'masterobat_id', 'id');
    }
}
