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
        //$keys = array('name', 'town', 'post_code');
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
        	echo 'Pub ID: ' . $this->id.PHP_EOL;
            // Exception will be thrown here
            die($e->getMessage());
        }
        return $this;
    }

    /**
	 * Calculates the great-circle distance between two points, with
	 * the Vincenty formula.
	 * @param float $latitudeFrom Latitude of start point in [deg decimal]
	 * @param float $longitudeFrom Longitude of start point in [deg decimal]
	 * @param float $latitudeTo Latitude of target point in [deg decimal]
	 * @param float $longitudeTo Longitude of target point in [deg decimal]
	 * @param float $earthRadius Mean earth radius in [m]
	 * @return float Distance between points in [m] (same as earthRadius)
	 */
	public static function vincentyGreatCircleDistance(
  		$latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
		{
		  	// convert from degrees to radians
			$latFrom = deg2rad($latitudeFrom);
		  	$lonFrom = deg2rad($longitudeFrom);
		  	$latTo = deg2rad($latitudeTo);
		  	$lonTo = deg2rad($longitudeTo);

		  	$lonDelta = $lonTo - $lonFrom;
		  	$a = pow(cos($latTo) * sin($lonDelta), 2) +
		    pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
		  	$b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

		  	$angle = atan2(sqrt($a), $b);
		  	return $angle * $earthRadius;
		}

    public function placesApiSearch()
    {
    	$string = 'wetherspoon';
    	// if this pub even has geo?
    	if ($this->geo && $this->geo->lat && $this->geo->lon) {
	    	$google_places = new \joshtronic\GooglePlaces(Config::get('spoons.googleApi'));
	    	//$google_places->rankby   = 'prominence';
			$google_places->location = array($this->geo->lat, $this->geo->lon);
			$google_places->radius   = 100;
			$google_places->query      = $string;
			try {
				$results = $google_places->textSearch();
				$pubsByDistance = array();
				foreach ($results['results'] as $pub) {
					$distance = Self::vincentyGreatCircleDistance($this->geo->lat, $this->geo->lon, $pub['geometry']['location']['lat'], $pub['geometry']['location']['lng']);
					$pubsByDistance[$distance] = $pub;
				}
				if (count($pubsByDistance)) {
					ksort($pubsByDistance);
					$pub = array_values($pubsByDistance)[0];
					$this->geo->place_id  = $pub['id'];
					$this->geo->lat_precice = $pub['geometry']['location']['lat'];
					$this->geo->lon_precice = $pub['geometry']['location']['lng'];
					$this->geo->save();
				}
				
			} catch (\Exception $e) {
				// no results found
				//echo $e->getMessage();
			}
		}
		return $this;
    }

}