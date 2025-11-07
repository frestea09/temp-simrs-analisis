<?php

namespace App\AndroidSaderek;

use Illuminate\Database\Eloquent\Model;
use App\AndroidSaderek\MasterScreening;

class screeningPasienDetail extends Model
{
    protected $table    = 'saderek_screening_pasien_detail';

    protected $fillable = ['screening_pasien_id','screening_id','jawab','detail'];

    public function screening(){
        return $this->hasOne(MasterScreening::class,'id','screening_id');
    }
}
