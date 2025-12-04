<?php

namespace Modules\Pegawai\Entities;
use Illuminate\Database\Eloquent\Model;
use App\HRD\HrdBiodata;
use Modules\Pendidikan\Entities\Pendidikan;
use App\HRD\HrdStruktur;
use App\KuotaDokter;

class Pegawai extends Model {
	protected $fillable = ['poli_id','status','kuota_poli', 'nama', 'nik', 'kategori_pegawai','kelompok_pegawai','tgllahir', 'tmplahir', 'kelamin', 'agama', 'alamat', 'sip', 'sip_awal', 'sip_akhir', 'kode_bpjs', 'str', 'kompetensi', 'tupoksi', 'user_id','tanda_tangan','foto_profile','kode_dokter_inhealth', 'poli_type','id_dokterss','general_code','status_tte','smf'];

	public function biodata(){
		return $this->hasOne(HrdBiodata::class,'pegawai_id','id');
	}

	public function pendidikan(){
		return $this->hasOne(Pendidikan::class,'id','pendidikan_id');
	}

	public function struktur(){
		return $this->hasOne(HrdStruktur::class,'id','struktur_id');
	}
	public function pegawai()
	{
		return $this->hasOne(\Modules\Pegawai\Entities\Pegawai::class, 'user_id', 'id');
	}
	public function kd() //kuota dokter
    {
        return $this->hasOne(KuotaDokter::class, 'pegawai_id');
    }
}