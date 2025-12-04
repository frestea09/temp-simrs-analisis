<?php

namespace Modules\Registrasi\Entities;
use \App\Masterobat;
use Illuminate\Database\Eloquent\Model;

class BiayaFarmasi extends Model
{
    protected $table = 'biaya_farmasi';
    protected $fillable = ['nama_biaya'];
    //
    public function detail()
    {
        return $this->hasMany(BiayaFarmasiDetail::class, 'biaya_farmasi_id', 'id');
    }

    public function masterobat()
    {
        return $this->belongsTo(MasterObat::class, 'masterobat_id');
    }
}
