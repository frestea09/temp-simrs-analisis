<?php

namespace Modules\Registrasi\Entities;
use Illuminate\Database\Eloquent\Model;
use Modules\Tarif\Entities\Tarif;

class Biayaregistrasi extends Model
{
    protected $fillable = ['tipe','tarif_id','shift','tahuntarif_id'];

    public function tarif()
    {
        return $this->belongsTo(Tarif::class);
    }
}
