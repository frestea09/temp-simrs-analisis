<?php

namespace Modules\Accounting\Entities;

use Illuminate\Database\Eloquent\Model;

class PenguranganPiutang extends Model
{
    protected $table = 'akutansi_pengurangan_piutang';

    protected $fillable = [
        'akutansi_penyisihan_piutang_id',
        'tahun',
        'penyisihan',
        'penghapusan',
        'penambahan',
        'pembayaran'
    ];
}
