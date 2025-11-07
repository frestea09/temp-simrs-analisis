<?php

namespace App\HRD;

use Illuminate\Database\Eloquent\Model;
use Modules\Pegawai\Entities\Pegawai;
use App\HRD\HrdJenisCuti;
use App\HRD\HrdKepangkatan;
use App\HRD\HrdApproveCuti;

class HrdCuti extends Model
{
    protected $fillable = ['pegawai_id','biodata_id','jenis_cuti_id','tglmulai','tglselesai','nosk','tglsk','lama_cuti','alamat_cuti','telepon','kepala_ruangan_approved_by','kepala_ruangan_approved_at','kepala_instalasi_approved_by','kepala_instalasi_approved_at','kasubid_approved_by','kasubid_approved_at','ppk_approved_by','ppk_approved_at','status_kepala_ruangan','status_kepala_instalasi','status_kasubid','status_ppk','status_final','alasan_cuti','pelimpahan_tugas'];

    public function pegawai(){
        return $this->belongsTo(Pegawai::class, 'pegawai_id', 'id');
    }

    public function jenis_cuti(){
        return $this->belongsTo(HrdJenisCuti::class, 'jenis_cuti_id', 'id');
    }

    public function pegawai_pelimpahan(){
        return $this->belongsTo(Pegawai::class, 'pelimpahan_tugas', 'id');
    }

    public function kepangkatan(){
        return $this->hasOne(HrdKepangkatan::class, 'biodata_id', 'biodata_id');
    }

    public function approve_cuti(){
        return $this->hasMany(HrdApproveCuti::class, 'cuti_id', 'id')->orderBy('struktur_id', 'DESC');
    }
}
