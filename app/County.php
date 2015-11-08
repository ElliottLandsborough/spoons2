<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class County extends Model {

	//use SoftDeletes;

	protected $table = 'counties';
	public $timestamps = true;

	protected $fillable = array('name');



}