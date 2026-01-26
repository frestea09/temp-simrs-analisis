<?php

namespace App\Android;

use Illuminate\Database\Eloquent\Model;

class android_content extends Model
{
    protected $table    = 'android_content';

    protected $fillable = ['type_id','content_title','content_description','content_thumbnail','content_path','content_author'];
    
}
