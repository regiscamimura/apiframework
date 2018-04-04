<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Geo {

	public $earthRadius = 3958.76;
	public $milesPerDegreeLatitude = 69.172;

    /**
     * Provides the coordinates of the northeast and southwest bounds of a
     * square region, which circumscribed circle has a provided radius.
     *
     * @param  float  $lat
     * @param  float  $lng
     * @param  float  $radius
     * @return array
     */
	function get_bounds($lat, $lng, $radius) {
		$lat = deg2rad($lat);
        $lng = deg2rad($lng);

        $coord = array();
        for ($i = 0; $i < 4; $i++) {
            $coord[$i]['lat'] = rad2deg(asin(sin($lat) * cos($radius / UCHelper_Geo::$earthRadius) + cos($lat) * sin($radius / UCHelper_Geo::$earthRadius) * cos($i * pi() / 2)));
            $coord[$i]['lng'] = rad2deg($lng + atan2((sin(($i * pi() / 2)) * sin($radius / UCHelper_Geo::$earthRadius) * cos($lat)), (cos($radius / UCHelper_Geo::$earthRadius) - sin($lat) * sin($coord[$i]['lat']))));
        }

        $bounds = array();
        
        $bounds['NE']['lat'] = $coord[0]['lat'];
        $bounds['NE']['lng'] = $coord[1]['lng'];
        $bounds['SW']['lat'] = $coord[2]['lat'];
        $bounds['SW']['lng'] = $coord[3]['lng'];

        return $bounds;
	}
	
	/**
     * Calculate the [great-circle] distance (in statute miles) between two
     * given GPS coordinates. All coordinates are expected to be formatted
     * as decimal degress, such that they can immediately be converted
     * to radians. The average radius for a spherical approximation of
     * earth is 3958.76 miles.
     *
     * @param  float  $lat0
     * @param  float  $lng0
     * @param  float  $lat1
     * @param  float  $lng1
     * @return float
     */
    public function gpsDistance($lat0, $lng0, $lat1, $lng1) {
        // Convert the provided latitute/longitude coordinates to radians
        $lat0 = deg2rad($lat0);
        $lng0 = deg2rad($lng0);
        $lat1 = deg2rad($lat1);
        $lng1 = deg2rad($lng1);

        // Calulate the delta between longitudes
        $deltaLng = $lng1 - $lng0;

        // Build the numerator and denominator for the arctangent formula
        $y = sqrt((pow((cos($lat1) * sin($deltaLng)), 2) + (pow((cos($lat0) * sin($lat1)) - (sin($lat0) * cos($lat1) * cos($deltaLng)), 2))));
        $x = ((sin($lat0) * sin($lat1)) + (cos($lat0) * cos($lat1) * cos($deltaLng)));
        $arcTangent = atan2($y, $x);

        return $arcTangent * $this->earthRadius;
    }

    /**
     * Calculate the distance (in statute miles) of one degree of
     * longitude at a given latitude.
     *
     * @param  float  $lat
     * @return float
     */
    private function milesPerDegreeLongitude($lat) {
        return (pi() / 180) * $this->earthRadius * cos($lat);
    }
	
}

?>