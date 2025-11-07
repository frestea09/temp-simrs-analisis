<?php

namespace App\HRD;

use Illuminate\Database\Eloquent\Model;
use Modules\Pegawai\Entities\Pegawai;
use App\HRD\HrdStruktur;
use App\HRD\HrdCuti;

class HrdApproveCuti extends Model
{
    protected $table    = 'hrd_approved_cuti';
    protected $fillable = ['cuti_id', 'pegawai_id','biodata_id','struktur_id','status','alasan','tgl_awal','tgl_akhir','tampil'];
    
    public function pegawai(){
        return $this->belongsTo(Pegawai::class, 'pegawai_id', 'id');
    }

    public function struktur(){
        return $this->belongsTo(HrdStruktur::class, 'struktur_id', 'id');
    }

    public function cuti(){
        return $this->belongsTo(HrdCuti::class, 'cuti_id', 'id');
    }
}
