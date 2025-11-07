<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Penjualandetail;
use App\Logistik\LogistikBatch;
use Illuminate\Database\Eloquent\SoftDeletes;

class Masterobat extends Model
{
  protected $fillable = ['nama','kode','kategoriobat_id','satuanbeli_id','satuanjual_id','hargajual', 'hargajual_jkn', 'hargajual_kesda','hargabeli','aktif','kodekfa','id_medication'.'deleted_at'];

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

  public function detail()
  {
      return $this->hasMany(Penjualandetail::class);
  }

  public function logistik_batch(){
    return $this->belongsTo(LogistikBatch::class,'id','masterobat_id')->orderBy('updated_at','DESC');
    // return $this->hasMany(LogistikBatch::class,'masterobat_id','id')->orderBy('updated_at','DESC');
	}

  use SoftDeletes;

}
