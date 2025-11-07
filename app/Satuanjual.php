<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Satuanjual extends Model
{
    protected $fillable = ['nama'];
    public function masterobat()
    {
      return $this->hasMany(Masterobat::class);
    }
}
