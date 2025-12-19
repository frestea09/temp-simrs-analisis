<?php

namespace App\HRD;

use Illuminate\Database\Eloquent\Model;

class HrdStruktur extends Model
{
    protected $table    = 'hrd_struktur';
    protected $fillable = ['nama', 'parent_id'];
    
    public function children()
    {
        return $this->hasMany('App\HRD\HrdStruktur', 'parent_id');
    }

    public function childrenLocation()
    {
        return $this->hasMany('App\HRD\HrdStruktur', 'parent_id')->with(['children']);
    }

    public function parent(){
        return $this->belongsTo('App\HRD\HrdStruktur', 'parent_id', 'id');
    }

    public function up_category(){
        return $this->belongsTo('App\HRD\HrdStruktur', 'parent_id', 'id')->with(['parent']);
    }

}
