<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    protected $fillable = ['nama','politype','flag','bpjs','instalasi_id','kamar_id', 'terisi'];
 

}
