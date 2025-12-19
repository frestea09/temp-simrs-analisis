<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class inhealthSjp extends Model
{
    protected $table = 'inhealth_sjp';

    protected $fillable = ['reg_id', 'no_sjp', 'tgl_sjp', 'nama_poli', 'noka_peserta', 'plan_desc','kelas','nomor_rm','jenis_kelamin','tgl_lahir','tgl_rujukan','jenis_pelayanan'];
}
