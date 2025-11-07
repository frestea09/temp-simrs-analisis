<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class ObatAntibiotik extends Model
{
    protected $table = 'obat_antibiotik';


    public function masterobat()
    {
        return $this->belongsTo(Masterobat::class);
    }
}