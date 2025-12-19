<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class HistorikunjunganIRJ extends Model
{
    protected $table = 'histori_kunjungan_irj';
    protected $fillable = ['id', 'registrasi_id', 'pasien_id', 'dokter_id', 'poli_id', 'created_at', 'updated_at'];

}
