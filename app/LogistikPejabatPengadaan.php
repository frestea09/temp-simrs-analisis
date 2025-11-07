<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogistikPejabatPengadaan extends Model
{
    protected $table = 'logistik_pejabat_pengadaans';
    protected $fillable = ['nip', 'nama', 'jabatan'];
}
