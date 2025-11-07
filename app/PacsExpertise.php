<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class PacsExpertise extends Model {
	protected $table    = 'pacs_expertise';
    protected $fillable = ['acc_number', 'no_rm','nama','kelamin','service','exam_room','status','spv','expertise'];
}