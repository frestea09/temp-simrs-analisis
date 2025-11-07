<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Modules\Tarif\Entities\Tarif;

class Conf_rl36 extends Model
{
    public $timestamps = false;

    protected $table = 'conf_rl36';

    protected $fillable = ['nama'];

    public function tarif()
    {
      return $this->hasMany(Tarif::class,'rl36_id','id');
    }
}
