<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Modules\Kelas\Entities\Kelas;

class PaguPerawatan extends Model {
	protected $table    = 'pagu_perawatans';
	protected $fillable = ['biaya', 'diagnosa_awal', 'kelas_id'];

	public function kelas()
	{
		return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
	}
}