<?php

namespace Modules\Accounting\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Accounting\Entities\Master\AkunCOA;
use Modules\Accounting\Entities\Master\KasDanBank;

class JournalDetail extends Model
{
    protected $table = 'akutansi_journal_details';

    protected $fillable = [
        'id_journal',
        'id_akun_coa',
        'id_kas_dan_bank',
        'id_tarif',
        'is_operasional',
        'debit',
        'credit',
        'type',
        'keterangan'
    ];

    public function akun()
    {
        return $this->hasOne(AkunCOA::class, 'id', 'id_akun_coa');
    }

    public function kas_bank()
    {
        return $this->hasOne(KasDanBank::class, 'id', 'id_kas_dan_bank');
    }
}
