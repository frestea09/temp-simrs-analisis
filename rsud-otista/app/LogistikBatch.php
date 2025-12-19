<?php

namespace App;

use App\Logistik\Logistik_BAPB;
use Illuminate\Database\Eloquent\Model;
use App\Masterobat;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogistikBatch extends Model
{
    use SoftDeletes;
    //
    public function satuanbeli()
  {
    return $this->belongsTo(Satuanbeli::class);
  }

  public function satuanjual()
  {
    return $this->belongsTo(Satuanjual::class);
  }

  public function kategoriobat()
  {
    return $this->belongsTo(Kategoriobat::class);
  }

  public function master_obat(){
    return $this->hasOne(Masterobat::class,'id','masterobat_id');
	}
  public function bapb()
  {
    return $this->hasOne(Logistik_BAPB::class,'id','bapb_id');
  }
}
