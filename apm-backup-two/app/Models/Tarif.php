<?php

namespace App\Models;

use App\Mastermapping;
use App\Modality;
use Illuminate\Database\Eloquent\Model;
use Modules\Accounting\Entities\Master\AkunCOA;
use Modules\Kategoritarif\Entities\Kategoritarif;
use Modules\Kategoriheader\Entities\Kategoriheader;
use Modules\Config\Entities\Tahuntarif;
use Modules\Config\Entities\Kelompoktarif;
use Modules\Registrasi\Entities\Biayaregistrasi;
use Modules\Registrasi\Entities\Folio;
use Modules\Kelas\Entities\Kelas;

class Tarif extends Model
{
    protected $fillable = ['id_tindakan','jenis_akreditasi','lica_id','visite','nama', 'kode', 'jenis', 'kelas_id', 'kategoriheader_id', 'kategoritarif_id', 'keterangan', 'tahuntarif_id','kelompoktarif_id','kelompok','jasa_rs','jasa_pelayanan','total','carabayar','mastermapping_id','mapping_biaya_id','mapping_pemeriksaan','rl33_id','rl36_id', 'akutansi_akun_coa_id', 'is_aktif'];

    public function kategoritarif()
    {
        return $this->belongsTo(Kategoritarif::class);
    }
    public function kategoriheader()
    {
        return $this->belongsTo(Kategoriheader::class);
    }
    public function tahuntarif()
    {
        return $this->belongsTo(Tahuntarif::class);
    }
    public function kelompoktarif()
    {
        return $this->belongsTo(Kelompoktarif::class);
    }
    public function kelas(){
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }
    public function modality(){
        return $this->belongsTo(Modality::class, 'modality_id', 'id');
    }
    public function biayaregistrasi()
    {
        return $this->hasMany(Biayaregistrasi::class);
    }
    public function folio()
    {
        return $this->hasMany(Folio::class);
    }
    public function akun_coa()
    {
        return $this->belongsTo(AkunCOA::class, 'akutansi_akun_coa_id', 'id');
    }

    public function mastermapping()
    {
        return $this->hasOne(Mastermapping::class, 'id', 'mastermapping_id');
    }
}
