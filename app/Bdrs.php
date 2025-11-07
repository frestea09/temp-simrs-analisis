<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bdrs extends Model
{
    protected $table = 'bdrs';
    protected $guarded = [];

    public function detail()
    {
        return $this->hasMany(BdrsDetail::class,'bdrs_id','id');
    }
}
