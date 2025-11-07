<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class KuotaDokter extends Model
{
    protected $table = 'kuota_dokter';
    protected $fillable = [
        'pegawai_id', 'kuota', 'loket', 'buka', 'tutup', 'kode_loket',
        'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday',
        'jkn_monday', 'jkn_tuesday', 'jkn_wednesday', 'jkn_thursday', 'jkn_friday', 'jkn_saturday', 'jkn_sunday'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}