<?php

namespace App\Logistik;

use Illuminate\Database\Eloquent\Model;

class LogistikPejabatBendahara extends Model
{
    //
    protected $table = 'logistik_pejabat_bendaharas';
    protected $fillable = ['sk','nip', 'nama', 'jabatan'];
}
