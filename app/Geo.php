<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Geo extends Model {

	//use SoftDeletes;

	protected $table = 'geos';
	public $timestamps = true;

	protected $fillable = array('lat', 'lon', 'pub_id', 'place_id', 'lat_precice', 'lon_precice');



}