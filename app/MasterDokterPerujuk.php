<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterDokterPerujuk extends Model
{
    protected $table = 'master_dokter_perujuk';

    protected $fillable = ['nama','alamat'];
}
