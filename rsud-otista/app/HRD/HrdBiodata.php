<?php

namespace App\HRD;

use Illuminate\Database\Eloquent\Model;
use Modules\Pegawai\Entities\Pegawai;
use App\HRD\HrdKepangkatan;

class HrdBiodata extends Model
{
    protected $table    = 'hrd_biodatas';
    protected $fillable = ['namalengkap', 'tmplahir','tgllahir','kelamin','goldarah','suku','warganegara','agama_id','statuskawin','alamat','province_id','regency_id','district_id','village_id','notlp','nohp','kdpos','email','gelar_dpn','gelar_blk','tmpcpns','dupeg','nokartupegawai','noktp','noaskes','notaspen','npwp','nokarsu','jenisfungsional','funcgsional','fungsionaltertentu','foto','pegawai_id','is_mutasi'];
    
    public function keluarga()
    {
        return $this->hasOne('App\HRD\HrdKeluarga', 'biodata_id', 'id');
    }

    public function pegawai(){
        return $this->belongsTo(Pegawai::class, 'pegawai_id', 'id');
    }

    public function kepangkatan(){
        return $this->hasOne(HrdKepangkatan::class, 'biodata_id', 'id');
    }
}
