<?php

namespace Modules\Registrasi\Entities;

use App\Antrian;
use App\Emr;
use App\EmrGizi;
use App\EmrKonsul;
use App\EmrInapPemeriksaan;
use App\EmrInapPerencanaan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Pasien\Entities\Pasien;
use Modules\Registrasi\Entities\Dokter;
use Modules\Poli\Entities\Poli;
use Modules\Sebabsakit\Entities\Sebabsakit;
use Modules\Registrasi\Entities\Carabayar;
use Modules\Registrasi\Entities\Tagihan;
use Modules\Rujukan\Entities\Rujukan;
use Modules\Perusahaan\Entities\Perusahaan;
use App\User;
use App\Pasienlangsung;
use App\RadiologiEkspertise;
use App\ResepNote;
use App\KondisiAkhirPasien;
use App\PerawatanIcd10;
use App\PerawatanIcd9;
use App\Rawatinap;
use App\Penjualan;
use App\RujukanObat;
use App\HistoriOrderLab;
use App\Hasillab;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Registrasi\Entities\Folio;
use App\AntrianRadiologi;
use App\AntrianLaboratorium;
use App\EmrResume;

class Registrasi extends Model
{
    protected $fillable = [];

    //SoftDelete
    use SoftDeletes;
    protected $dates  = ['deleted_at'];
    //EndSoftDelete
    public function resepNote()
    {
        return $this->hasOne(ResepNote::class, 'registrasi_id')->whereNotNull('nomor');
    }

    public function konsulJawab()
    {
        return $this->hasOne(EmrKonsul::class, 'registrasi_id')->where('type', 'jawab_konsul')->orderBy('id', 'desc');
    }

    public function konsulDokter()
    {
        return $this->hasOne(EmrKonsul::class, 'registrasi_id')->where('type', 'konsul_dokter')->orderBy('id', 'desc');
    }
    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }
    public function antrian()
    {
        return $this->belongsTo(Antrian::class);
    }

    public function pasien_langsung()
    {
        return $this->belongsTo(Pasienlangsung::class);
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }

    public function poli()
    {
        return $this->belongsTo(Poli::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sebabsakit()
    {
        return $this->belongsTo(Sebabsakit::class);
    }

    public function bayars()
    {
        return $this->belongsTo(Carabayar::class, 'bayar');
    }

    public function tagihan()
    {
      return $this->hasMany(Tagihan::class);
    }

    public function rujukans()
    {
      return $this->belongsTo(Rujukan::class);
    }

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class);
    }

    // tambahan
    public function rujukan()
    {
      return $this->hasOne(Rujukan::class, 'id', 'rujukan');
    }

    public function ekspertise()
    {
      return $this->hasMany(RadiologiEkspertise::class, 'registrasi_id', 'id')->where('poli_id', 1);
    }

    public function ekspertise_gigi()
    {
      return $this->hasMany(RadiologiEkspertise::class, 'registrasi_id', 'id')->where('poli_id', 38);
    }

    public function e_resep()
    {
      return $this->hasMany(ResepNote::class, 'registrasi_id', 'registrasi_id');
    }

    public function eResep()
    {
      return $this->hasMany(ResepNote::class, 'registrasi_id', 'id');
    }

    public function eResepTTE()
    {
      return $this->hasOne(ResepNote::class, 'registrasi_id', 'id')->whereNotNull('tte');
    }

    public function kondisi_akhir()
    {
        return $this->hasOne(KondisiAkhirPasien::class,'id','kondisi_akhir_pasien');
    }

    public function rawat_inap()
    {
        return $this->belongsTo(Rawatinap::class,'id','registrasi_id');
    }

    public function dokter_umum()
    {
        return $this->hasOne(Pegawai::class,'id','dokter_id');
    }

    public function cara_bayar()
    {
        return $this->hasOne(Carabayar::class,'id','bayar');
    }

    public function layanan()
    {
        return $this->hasOne(Poli::class,'id','poli_id');
    }

    public function folio()
    {
      return $this->hasMany(Folio::class,'registrasi_id','id');
    }

    public function emrPemeriksaan()
    {
        return $this->hasMany(EmrInapPemeriksaan::class, 'registrasi_id', 'id');
    }
   
    // end tambahan
    public function icd10s()
    {
        return $this->hasMany(PerawatanIcd10::class, 'registrasi_id', 'id');
    }
    public function icd9s()
    {
        return $this->hasMany(PerawatanIcd9::class, 'registrasi_id', 'id');
    }
    public function caraPulang()
    {
        return $this->hasOne(KondisiAkhirPasien::class, 'id', 'pulang');
    }
    public function kondisiAkhir()
    {
        return $this->hasOne(KondisiAkhirPasien::class, 'id', 'kondisi_akhir_pasien');
    }

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'registrasi_id', 'id');
    }

    public function pengkajian_gizi()
    {
        return $this->hasOne(EmrInapPemeriksaan::class, 'registrasi_id', 'id')->where('type', 'fisik_gizi');
    }

    public function skrining_anak()
    {
        return $this->hasOne(EmrInapPemeriksaan::class, 'registrasi_id', 'id')->where('type', 'inap-perawat-anak');
    }
    
    public function skrining_dewasa()
    {
        return $this->hasOne(EmrInapPemeriksaan::class, 'registrasi_id', 'id')->where('type', 'inap-perawat-dewasa');
    }

    public function skrining_maternitas()
    {
        return $this->hasOne(EmrInapPemeriksaan::class, 'registrasi_id', 'id')->where('type', 'asesmen-awal-perawat-maternitas');
    }

    public function skrining_perinatologi()
    {
        return $this->hasOne(EmrInapPemeriksaan::class, 'registrasi_id', 'id')->where('type', 'asesmen-perinatologi');
    }

    public function formulir_edukasi()
    {
        return $this->hasOne(EmrInapPemeriksaan::class, 'registrasi_id', 'id')->where('type', 'formulir-edukasi-inap');
    }

    public function layanan_rehab()
    {
        return $this->hasOne(EmrInapPemeriksaan::class, 'registrasi_id', 'id')->where('type', 'layanan_rehab');
    }

    public function program_terapi()
    {
        return $this->hasOne(EmrInapPemeriksaan::class, 'registrasi_id', 'id')->where('type', 'program_terapi_rehab');
    }

    public function uji_fungsi()
    {
        return $this->hasOne(EmrInapPemeriksaan::class, 'registrasi_id', 'id')->where('type', 'uji_fungsi_rehab');
    }

    public function apgar_score()
    {
        return $this->hasOne(EmrInapPemeriksaan::class, 'registrasi_id', 'id')->where('type', 'apgar-score');
    }

    public function triage()
    {
        return $this->hasOne(EmrInapPemeriksaan::class, 'registrasi_id', 'id')->where('type', 'triage-igd');
    }

    public function partograf()
    {
        return $this->hasOne(EmrInapPemeriksaan::class, 'registrasi_id', 'id')->where('type', 'partograf');
    }
    
    public function laporan_kuret()
    {
        return $this->hasOne(EmrInapPerencanaan::class, 'registrasi_id', 'id')->where('type', 'laporan-kuret');
    }
    
    public function laporan_persalinan()
    {
        return $this->hasOne(EmrInapPemeriksaan::class, 'registrasi_id', 'id')->where('type', 'laporan-persalinan');
    }

    public function obat_rujukan()
    {
        return $this->hasOne(RujukanObat::class, 'registrasi_id', 'id');
    }

    public function hasilLab()
    {
      return $this->hasMany(Hasillab::class, 'registrasi_id', 'id');
    }

    public function hasilLab_klinis()
    {
      return $this->hasMany(Hasillab::class, 'registrasi_id', 'id')->where('no_lab', 'not like', '%LABR%');
    }

    public function hasilLab_patalogi()
    {
      return $this->hasMany(Hasillab::class, 'registrasi_id', 'id')->where('no_lab', 'like', '%LABR%');
    }

    public function aswal()
    {
        return $this->hasMany(EmrInapPemeriksaan::class, 'registrasi_id', 'id')->where('type', 'like', 'fisik_%')->orWhere('type', 'like', 'assesment-awal-medis%');
    }

    public function cppt()
    {
        return $this->hasMany(Emr::class, 'registrasi_id', 'id');
    }

    public function cppt_gizi()
    {
        return $this->hasMany(EmrGizi::class, 'registrasi_id', 'id');
    }

    public function askep_and_askeb()
    {
        return $this->hasMany(EmrInapPemeriksaan::class)->where('type', 'asuhan-kebidanan')->orWhere('type', 'asuhan-keperawatan');
    }
    public function folioLab()
    {
      return $this->hasMany(Folio::class,'registrasi_id','id')->where('poli_tipe', 'L');
    }

    public function folioLabPA()
    {
      return $this->hasMany(Folio::class,'registrasi_id','id')->where('poli_id', 43)->where('poli_tipe', 'L');
    }
    
    public function folioBelumLunas()
    {
      return $this->hasMany(Folio::class,'registrasi_id','id')->where('lunas', 'N');
    }

    public function historyOrderLab()
    {
      return $this->hasMany(HistoriOrderLab::class,'registrasi_id','id');
    }

    public function konsul()
    {
      return $this->hasMany(EmrKonsul::class,'registrasi_id','id')->where('type', 'konsul_dokter');
    }

    public function kematian()
    {
      return $this->hasOne(EmrInapPerencanaan::class, 'registrasi_id','id')->where('type', 'kematian');
    }

    public function paps()
    {
      return $this->hasOne(EmrInapPerencanaan::class, 'registrasi_id','id')->where('type', 'surat-paps');
    }

    public function rujukan_rumah_sakit()
    {
      return $this->hasOne(EmrInapPerencanaan::class, 'registrasi_id','id')->where('type', 'rujukan_rumah_sakit');
    }

    public function resume_igd()
    {
      return $this->hasOne(EmrResume::class, 'registrasi_id','id')->where('type', 'resume-igd');
    }
    public function antrianRad()
    {
        return $this->hasMany(AntrianRadiologi::class, 'registrasi_Id', 'id');
    }
    public function antrianLab()
    {
        return $this->hasMany(AntrianLaboratorium::class, 'registrasi_Id', 'id');
    }
    public function dummy()
    {
        return $this->hasOne(\App\RegistrasiDummy::class, 'registrasi_id', 'id');
    }
}
