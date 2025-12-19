<?php

namespace App\Models\Pasien;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pasien\District;

class Village extends Model
{
    protected $fillable = [];
    public $incrementing = false;
    protected $primaryKey = 'id';

    public function kecamatan(){
        return $this->hasOne(District::class,'id','district_id');
    }
}
