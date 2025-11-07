<?php

namespace App\Logistik;

use Illuminate\Database\Eloquent\Model;

class PejabatPengecekan extends Model
{
    //
    protected $table = 'logistik_pejabat_pemeriksa';
    protected $fillable = ['nip', 'nama', 'jabatan'];
}
