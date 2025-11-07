<?php

namespace App\Logistik;

use Illuminate\Database\Eloquent\Model;
use App\Masterobat;

class LogistikNoBatch extends Model
{
    public function master_obat(){
        return $this->hasOne(Masterobat::class,'id','masterobat_id');
    }
    
}
