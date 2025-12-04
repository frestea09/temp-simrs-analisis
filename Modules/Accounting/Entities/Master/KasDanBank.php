<?php

namespace Modules\Accounting\Entities\Master;

use Illuminate\Database\Eloquent\Model;
use Modules\Accounting\Entities\JournalDetail;

class KasDanBank extends Model
{
    protected $table = 'akutansi_kas_dan_banks';

    protected $fillable = [
        'akun_coa_id',
        'code',
        'nama',
        'no_rek',
        'status',
        'keterangan'
    ];

    public function akun_coa()
    {
        return $this->hasOne(AkunCOA::class, 'id', 'akun_coa_id');
    }

    public function jounal_detail()
    {
        return $this->hasMany(JournalDetail::class, 'id_kas_dan_bank', 'id');
    }
}
