<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Laboratorium;
use App\RincianHasillab;

class Labkategori extends Model
{
    protected $fillable = ['nama', 'labsection_id'];
    
    use SoftDeletes;
    protected $dates  = ['deleted_at'];

    public function laboratorium()
    {
      return $this->hasMany(Laboratorium::class);
    }

    public function rincian()
    {
        return $this->hasMany(RincianHasillab::class);
    }

}
