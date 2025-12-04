<?php

namespace Modules\Accounting\Entities;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $table = 'akutansi_journals';

    protected $fillable = [
        'id_supplier',
        'id_customer',
        'contact_type',
        'code',
        'tanggal',
        'total_transaksi',
        'type',
        'keterangan',
        'verifikasi'
    ];

    public function journal_detail()
    {
        return $this->hasMany(JournalDetail::class, 'id_journal', 'id');
    }
}
