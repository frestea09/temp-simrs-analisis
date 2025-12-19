<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model {
	protected $fillable = ['status', 'nama', 'nik', 'kategori_pegawai', 'tgllahir', 'tmplahir', 'kelamin', 'agama', 'alamat', 'sip', 'sip_awal', 'sip_akhir', 'kode_bpjs', 'str', 'kompetensi', 'tupoksi', 'user_id','kode_dokter_inhealth'];
}
