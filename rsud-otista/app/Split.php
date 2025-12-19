<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Split extends Model
{
    protected $fillable = ['tahuntarif_id', 'kategoriheader_id', 'tarif_id', 'nama', 'nominal'];
}
