<?php

namespace Modules\Accounting\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Registrasi\Entities\Carabayar;

class PenyisihanPiutang extends Model
{
    protected $table = 'akutansi_penyisihan_piutang';

    protected $fillable = [
        'tahun',
        'cara_bayar_id',
        'saldo_piutang'
    ];

    public function carabayar()
    {
        return $this->belongsTo(Carabayar::class, 'cara_bayar_id', 'id');
    }

    public function pengurangan()
    {
        return $this->hasOne(PenguranganPiutang::class, 'akutansi_penyisihan_piutang_id', 'id')->orderBy('tahun', 'DESC');
    }
}
