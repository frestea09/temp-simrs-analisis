<?php

namespace App\Conf_rl;

use Illuminate\Database\Eloquent\Model;

class M_config38 extends Model
{
    protected $table    = 'conf_rl38';

    protected $fillable = ['kegiatan','nomer','create_at'];
    protected $primaryKey ='id_conf_rl38';

    
    // public function employe()
    // {
    //     return $this->hasMany('App\Model\EmployeesModel', 'company_id', 'id_company');
    // }
}
