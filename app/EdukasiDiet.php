<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MasterDiet;

class EdukasiDiet extends Model
{
    // protected $table    = 'master_diets';
    public function diet()
    {
        return $this->belongsTo(MasterDiet::class, 'nama', 'kode', 'id_composition_ss');
        
    }
}
