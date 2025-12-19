<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Modules\Registrasi\Entities\Registrasi;

class BpjsPRB extends Model
{
    protected $table    = 'bpjs_prb';
	protected $fillable = ['reg_id', 'pasien_id','no_srb','no_sep','no_kartu','alamat','email','program_prb','kode_dpjp','keterangan','saran','user','created_by'];

    public function registrasi(){
        return $this->hasOne(Registrasi::class,'id','reg_id');
    }
}
