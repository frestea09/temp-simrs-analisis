<?php

namespace App\HRD;

use Illuminate\Database\Eloquent\Model;

class HrdMutasi extends Model
{
    protected $table    = 'hrd_mutasi';
    protected $fillable = ['id', 'pegawai_id','biodata_id','tgl_mutasi','keterangan','status'];
}
