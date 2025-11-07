<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Labsection extends Model
{
    protected $fillable = ['nama']; 
    
    use SoftDeletes;
    protected $dates  = ['deleted_at'];
}
