<?php

namespace App\AndroidSaderek;

use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    protected $table    = 'saderek_poli';

    protected $fillable = ['nama','kode_bpjs','kuota','kuota_online','status'];
}
