<?php

namespace App\AndroidSaderek;

use Illuminate\Database\Eloquent\Model;

class Operasi extends Model
{
    protected $table    = 'saderek_operasi';

    protected $fillable = ['kode_booking','no_jkn','kode_poli','nama_poli','terlaksana','no_peserta','jenis_tindakan','rencana_operasi'];
}
