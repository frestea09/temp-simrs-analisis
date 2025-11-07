<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImplementasiKeperawatan extends Model
{
    protected $table    = 'implementasi_keperawatans';
	protected $guarded = 'id';

    public function diagnosaKeperawatan(){
        return $this->belongsTo(DiagnosaKeperawatan::class, 'diagnosa_keperawatan_id', 'id');
    }
}
