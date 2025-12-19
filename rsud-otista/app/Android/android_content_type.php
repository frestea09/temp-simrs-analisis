<?php

namespace App\Android;

use Illuminate\Database\Eloquent\Model;

class android_content_type extends Model
{
    protected $table    = 'android_content_type';

    protected $fillable = ['type_nama','type_slug'];
    
    public $timestamps = false;
}
