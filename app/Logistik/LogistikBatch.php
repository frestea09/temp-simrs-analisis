<?php

namespace App\Logistik;

use Illuminate\Database\Eloquent\Model;
use App\Masterobat;

class LogistikBatch extends Model
{
    protected $table = 'logistik_batches';

    public function master_obat(){
        return $this->hasOne(Masterobat::class,'id','masterobat_id');
    }
}
