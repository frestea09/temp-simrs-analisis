<?php

namespace App\AndroidSaderek;

use Illuminate\Database\Eloquent\Model;
use App\AndroidSaderek\screeningPasienDetail;

class screeningPasien extends Model
{
    protected $table    = 'saderek_screening_pasien';

    protected $fillable = ['uuid','reg_id','nik','nama','umur','alamat','jenis','hasil','status','suhu_tubuh','check_in','infeksi_covid'];

    public function screening_detail(){
        return $this->hasMany(screeningPasienDetail::class,'screening_pasien_id','id');
    }
}
