<?php

namespace Modules\Poli\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Politype\Entities\Politype;
use Modules\Instalasi\Entities\Instalasi;
use Modules\Kamar\Entities\Kamar;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Registrasi\Entities\Folio;
use Modules\Registrasi\Entities\Dokter;
use Illuminate\Database\Eloquent\SoftDeletes;

class Poli extends Model
{
    // protected $fillable = ['nama','politype','flag','bpjs','instalasi_id','kamar_id', 'terisi','id_location_ss','description','audio','kelompok','dokter_id', 'perawat_id','kkuota'];
    // protected $fillable = [];
    use SoftDeletes;
    protected $guarded = [];

    public function politype()
    {
        return $this->belongsTo(Politype::class, 'kode', 'politype');
    }

    public function instalasi()
    {
        return $this->belongsTo(Instalasi::class);
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }

    public function registrasi()
    {
        return $this->hasMany(Registrasi::class);
    }

    public function folio()
    {
      return $this->hasMany(Folio::class);
    }

    public function dokter()
    {
        return $this->hasMany(Dokter::class);
    }

}
