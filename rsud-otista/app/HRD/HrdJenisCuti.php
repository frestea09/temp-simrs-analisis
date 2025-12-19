<?php

namespace App\HRD;

use Illuminate\Database\Eloquent\Model;

class HrdJenisCuti extends Model
{
    protected $table    = 'hrd_jenis_cuti';
	protected $fillable = ['nama', 'kuota'];
}
