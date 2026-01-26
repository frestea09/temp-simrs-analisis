<?php

namespace App\Models;
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
use App\Rawatinap;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Registrasi\Entities\Folio;

class Registrasi extends Model
{
    protected $fillable = [];

    //SoftDelete
    use SoftDeletes;
    protected $dates  = ['deleted_at'];
    //EndSoftDelete

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
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
      return $this->hasMany(RadiologiEkspertise::class, 'registrasi_id', 'id');
    }

    public function e_resep()
    {
      return $this->hasMany(ResepNote::class, 'registrasi_id', 'registrasi_id');
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
    // end tambahan

}
