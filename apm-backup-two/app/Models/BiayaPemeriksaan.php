<?php

namespace App\Models;
use App\Models\Tarif;
use Illuminate\Database\Eloquent\Model;

class BiayaPemeriksaan extends Model
{
    protected $fillable = ['tipe','tarif_id','pasien','poli_id'];
    //
    public function tarif()
    {
        return $this->belongsTo(Tarif::class);
    }
}
