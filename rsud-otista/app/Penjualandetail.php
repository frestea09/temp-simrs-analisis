<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Masterobat;
use App\LogistikBatch;

class Penjualandetail extends Model
{
  public function masterobat()
  {
      return $this->belongsTo(Masterobat::class, 'masterobat_id')->withTrashed();
  }
  public function logistik_batch()
  {
      return $this->hasOne(LogistikBatch::class,'id','logistik_batch_id');
  }
  public function logistik_batch_with_trashed()
  {
      return $this->hasOne(LogistikBatch::class,'id','logistik_batch_id')->withTrashed();
  }
}
