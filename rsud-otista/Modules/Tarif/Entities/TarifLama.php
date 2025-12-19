<?php

namespace Modules\Tarif\Entities;

use App\Mastermapping;
use Illuminate\Database\Eloquent\Model;
use Modules\Accounting\Entities\Master\AkunCOA;
use Modules\Kategoritarif\Entities\Kategoritarif;
use Modules\Kategoriheader\Entities\Kategoriheader;
use Modules\Config\Entities\Tahuntarif;
use Modules\Registrasi\Entities\Biayaregistrasi;
use Modules\Registrasi\Entities\Folio;

class TarifLama extends Model
{
    protected $table = 'tarif_old';
    protected $fillable = ['id_tindakan','jenis_akreditasi','lica_id','visite','nama', 'kode', 'jenis', 'kelas_id', 'kategoriheader_id', 'kategoritarif_id', 'keterangan', 'tahuntarif_id','kelompok','jasa_rs','jasa_pelayanan','total','carabayar','mastermapping_id','mapping_biaya_id','mapping_pemeriksaan','rl33_id','rl36_id', 'akutansi_akun_coa_id'];

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
