<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategoriobat extends Model
{
    protected $fillable = ['nama'];
    
    public function masterobat()
    {
      return $this->hasMany(Masterobat::class);
    }
}
