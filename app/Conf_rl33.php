<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Modules\Tarif\Entities\Tarif;

class Conf_rl33 extends Model
{
    public $timestamps = false;
    
    protected $table = 'conf_rl33';

    protected $fillable = ['nama', 'jumlah'];

    public function tarif()
    {
      return $this->hasMany(Tarif::class,'rl33_id','id');
    }
}
