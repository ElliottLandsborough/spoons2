<?php

namespace App\Http\Controllers;

use File;

use App\County;
use App\Pub;

class SpoonsController extends Controller
{

	public function test() {
		Pub::getLatLon();
	}

}