<?php

namespace App\Models\Pasien;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pasien\Province;

class Regency extends Model
{
    protected $fillable = [];
    public $incrementing = false;
    protected $primaryKey = 'id';

    public function provinsi(){
        return $this->hasOne(Province::class,'id','province_id');
    }
}
