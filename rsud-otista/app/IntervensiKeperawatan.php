<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IntervensiKeperawatan extends Model
{
    protected $table    = 'intervensi_keperawatans';
	protected $guarded = 'id';

    public function diagnosaKeperawatan(){
        return $this->belongsTo(DiagnosaKeperawatan::class, 'diagnosa_keperawatan_id', 'id');
    }
}
