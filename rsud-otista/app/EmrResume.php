<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmrResume extends Model
{
    protected $table = "emr_resume";
    use SoftDeletes;

}
