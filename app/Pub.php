<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use File;
use Config;

use Toin0u\Geocoder\Facade\Geocoder;

class Pub extends Model {

	//use SoftDeletes;

	protected $table = 'pubs';
	public $timestamps = true;

	protected $fillable = array('id','xmas_lunch','xmas_price','name','name_slug','address_line_1','address_line_2','town','county_id','post_code','url','cover_image_id');

	public function county() {
		return $this->belongsTo('App\County');
	}

	public function geo() {
		return $this->HasOne('App\Geo');
	}

	// take the spoons json and import it to the db
	static public function jsonToDb($json = null, $delete = false) {
		// json decode it - @ to avoid warnings
		$data = @json_decode($json);
		// handle any errors
		if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
    		return json_last_error();
		}
		// result is $object->pubs->[county]->[pub]->[address1,address2,etc]
		foreach ($data->pubs as $countyString=>$pubs) {
			// check if county already exists
			$dbCounty = County::where('name', $countyString)->first();
			if ($delete && $dbCounty) {
				$dbCounty->delete();
			}
			// if the county was not found
			if (!$dbCounty || ($delete && $dbCounty)) {
				// new one
				$county = new County;
				$county->name = $countyString;
				$county->save();
				$dbCounty = $county;
			}
			// loop through pubs
			foreach ($pubs as $pub) {
				// get current county id
				$pub->county_id = $dbCounty->id;
				$dbPub = Pub::where('id', $pub->id)->first();
				// do we want to delete the old record?
				if ($delete && $dbPub) {
					$dbPub->delete();
				}
				if (!$dbPub || ($delete && $dbPub)) {
					$dbPub = new Pub;
				}
				$dbPub->fill((array) $pub);
				$dbPub->save();
			}
		}
		return true;
	}

	static public function getSpoonsJson() {
		$jsonUrl = Config::get('spoons.jsonUrl');
		$file = Config::get('spoons.jsonDir') . DIRECTORY_SEPARATOR . 'pubs.spoons.' . date('Y.m.d.H.i.s') . '.json';
		$contents = file_get_contents($jsonUrl);
		File::put($file, $contents);
	}

	static public function getLatestJsonFileName() {
		$files = File::files(Config::get('spoons.jsonDir'));
		if ($files && count($files)) {
			return end($files);
		}
		return false;
	}

	// format the address for geocode search
    public function formatAddress()
    {
    	$pub = $this;
        $address = array();
        $pub->county = $pub->county->name;
        $keys = array('name', 'address_line_1', 'address_line_2', 'town', 'county', 'post_code');
        if (is_object($pub)) {
            foreach ($keys as $key) {
                if (strlen($pub->{$key})) {
                    $address[] = $pub->{$key};
                }
            }
            if (count($address)) {
            	$pub->fullAddress = implode($address, ', ');
            }
        }
        return $pub;
    }

    // geocode search by string
    public function geoCode()
    {
    	$string = $this->formatAddress()->fullAddress;
        try {
            $geocode = Geocoder::geocode($string);
            if ($geocode) {
            	$geo = new Geo(['lat'=>$geocode->getLatitude(), 'lon'=>$geocode->getLongitude()]);
            	$this->geo()->save($geo);
            }
        } catch (\Exception $e) {
            // Exception will be thrown here
            die($e->getMessage());
        }
        return $this;
    }

    static public function getLatLon() {

	}

}