<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\BpjsObatPRB;

class BpjsPRBDetail extends Model
{
    protected $table    = 'bpjs_prb_detail_obat';
	protected $fillable = ['bpjs_prb_id', 'kode_obat','signa_1','signa_2','jumlah'];

    public function obat(){
        return $this->hasOne(BpjsObatPRB::class,'kode','kode_obat');
    }
}
