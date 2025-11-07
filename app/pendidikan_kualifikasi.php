<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Modules\Pendidikan\Entities\Pendidikan;

class pendidikan_kualifikasi extends Model
{
    protected $table    = 'pendidikan_kualifikasi';
    protected $fillable = ['nama'];

    public $timestamps = false;

    public function pendidikan(){
        return $this->hasMany(Pendidikan::class,'kualifikasi_id','id');
    }
}
