<?php

namespace Modules\Registrasi\Entities;

use App\LogistikGudang;
use App\Penjualandetail;
use Illuminate\Database\Eloquent\Model;
use Modules\Pasien\Entities\Pasien;
use Modules\Poli\Entities\Poli;
use Modules\Tarif\Entities\Tarif;
use Modules\Tarif\Entities\TarifLama;
use Modules\Registrasi\Entities\Dokter;
use Modules\Registrasi\Entities\Registrasi;
use App\User;
use Modules\Pegawai\Entities\Pegawai;
use App\RadiologiEkspertise;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\LogFolio;

class Folio extends Model
{

    use SoftDeletes;

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            if (auth()->check()) {
                $url = url()->previous();
                $model->deleted_by = auth()->id();
                $model->save();
                LogFolio::create([
                    'user_id' => auth()->id(),
                    'text' => auth()->user()->name . ' Menghapus tindakan ' . $model->namatarif . ' Pada ' . date('d-m-Y H:i:s'),
                    'url' => $url,
                    'folio_id' => $model->id,
                ]);
            }
        });
    }

    protected $fillable = [];
    

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function registrasi()
    {
        return $this->hasOne(Registrasi::class,'id','registrasi_id');
    }

    public function poli()
    {
      return $this->belongsTo(Poli::class);
    }

    public function tarif()
    {
        // dd(config('app.tarif_new'));
        // if(config('app.tarif_new') < date('Y-m-d H:i')){
            // dd("LAMA");
            // dd(config('app.tarif_new'));
            // JIKA INPUTNYA KURANG DARI TANGGAIL DIATAS MAKA AMBIL DATA TARIF LAMA
        //     return $this->hasOne(TarifLama::class,'id','tarif_id');
        // }else{
            return $this->hasOne(Tarif::class, 'id','tarif_id');
            // return $this->belongsTo(Tarif::class);
            // dd("BARU");
            // JIKA INPUTNYA LEBIH DARI TANGGAIL DIATAS MAKA AMBIL DATA TARIF BARU
        // }
    }
    public function tarif_lama()
    {
        return $this->hasOne(TarifLama::class,'id','tarif_id');
        // return $this->belongsTo(TarifLama::class);
    }

    public function tarif_baru()
    {
        return $this->hasOne(Tarif::class, 'id','tarif_id');
    }

    public function dokter()
    {
        return $this->belongsTo(Pegawai::class, 'dokter_id', 'id');
    }
    public function dokterPelaksana()
    {
        return $this->belongsTo(Pegawai::class, 'dokter_pelaksana', 'id');
    }

    public function gudang()
    {
        return $this->hasOne(LogistikGudang::class,'id','gudang_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function obat()
    {
        return $this->hasMany(Penjualandetail::class,'no_resep','namatarif');
    }
    public function dokterRadiologi()
    {
        return $this->belongsTo(Pegawai::class, 'dokter_radiologi', 'id');
    }

    
}
