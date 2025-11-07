<?php

namespace App\Conf_rl;

use Illuminate\Database\Eloquent\Model;
use Modules\Kamar\Entities\Kamar;

class M_config31 extends Model
{
    protected $table    = 'conf_rl31';
    protected $fillable = ['kegiatan','nomer'];
    protected $primaryKey = 'id_conf_rl31';

    public function kamar()
    {
        return $this->hasMany(Kamar::class, 'conf_rl31_id', 'id_conf_rl31');
    }
}
