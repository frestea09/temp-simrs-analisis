<?php

namespace Modules\Accounting\Entities\Master;

use Illuminate\Database\Eloquent\Model;
use Modules\Accounting\Entities\JournalDetail;

class AkunCOA extends Model
{
    protected $table = 'akutansi_akun_coas';

    protected $fillable = [
        'akun_code_1',
        'akun_code_2',
        'akun_code_3',
        'akun_code_4',
        'akun_code_5',
        'akun_code_6',
        'akun_code_7',
        'akun_code_8',
        'akun_code_9',
        'code',
        'nama',
        'status',
        'saldo_normal',
        'keterangan'
    ];
}
