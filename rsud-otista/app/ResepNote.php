<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ResepNoteDetail;
use App\Penjualan;
use App\Penjualandetail;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Pasien\Entities\Pasien;

class ResepNote extends Model
{
    protected $table = 'resep_note';
    protected $fillable = ['id','input_from','signa_peracikan','tiket','poli_id','jenis_resep','notif_play','proses','nama_racikan','uuid','source','registrasi_id','pasien_id','comment','no_resep','status','created_by','is_done_input','nomor', 'panggil', 'panggil_play', 'kelompok', 'antrian_dipanggil'];

    public function resep_detail()
    {
        return $this->hasMany(ResepNoteDetail::class,'resep_note_id','id');
    }
    public function penjualan_detail()
    {
        return $this->hasMany(Penjualandetail::class,'penjualan_id','id');
    }
    public function pasien(){
        return $this->belongsTo(Pasien::class);
    }
    public function penjualan(){
        return $this->belongsTo(Penjualan::class);
    }
    public function penjualans(){
        return $this->hasOne(Penjualan::class,'id','penjualan_id');
    }
    public function registrasi(){
        return $this->belongsto(Registrasi::class);
    }
}
