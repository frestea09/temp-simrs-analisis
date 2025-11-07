<?php

namespace App\PPI;

use Illuminate\Database\Eloquent\Model;

class PpiFaktorPemakaian extends Model
{
    //
    public function master_ppi(){
        return $this->hasOne(MasterPpi::class,'id','master_ppi_id');
    }
}
