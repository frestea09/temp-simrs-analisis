<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Conf_rl\M_config312;

class RLKeluargaBerencana extends Model
{
    protected $table = 'rl_keluarga_berencana';

    protected $fillable = ['conf_rl312_id','reg_id','konseling','cara_masuk','kondisi','kunjungan_ulang','created_by'];

    public function conf312(){
        return $this->hasOne(M_config312::class,'id_conf_rl312','conf_rl312_id');
    }
}
