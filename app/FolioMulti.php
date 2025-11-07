<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Modules\Pasien\Entities\Pasien;
use Modules\Poli\Entities\Poli;
use Modules\Tarif\Entities\Tarif;
use Modules\Registrasi\Entities\Dokter;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\LogFolio;

class FolioMulti extends Model
{
    use SoftDeletes;
    protected $table    = 'folios';
    protected $fillable = ['registrasi_id','cyto','namatarif', 'cara_bayar_id','total','dibayar','tarif_id','lunas','dijamin','jenis','jenis_pasien','pasien_id','dokter_id','user_id','poli_id','poli_tipe','mapping_biaya_id','dpjp','dokter_pelaksana','dokter_anak', 'catatan','dokter_radiologi','dokter_lab','analis_lab','perawat','pelaksana_tipe','status_puasa','mulai_puasa','selesai_puasa','created_at', 'jam_masuk', 'jam_penanganan', 'order_lab_id', 'no_sediaan', 'diagnosa','verif_kasa_user','harus_bayar'];

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

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function poli()
    {
        return $this->belongsTo(Poli::class);
    }

    public function tarif()
    {
        return $this->belongsTo(Tarif::class);
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}