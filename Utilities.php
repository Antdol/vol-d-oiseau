<?php

class Utilities
{

    /**
     * calculateDistance
     * 
     * Calculate the distance between two points
     * 
     * @param float $lat1 latitude of the first point.
     * @param float $lon1 longitude of the first point.
     * @param float $lat2 latitude of the second point.
     * @param float $lon2 longitude of the second point.
     * @param string $unit unit of the result, by default in km. Use "m" for miles or "n" for nautical miles.
     * 
     * @return float distance between the two points in km, miles or nautical miles.
     */
    static public function calculateDistance($lat1, $lon1, $lat2, $lon2, $unit = "K")
    {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        } else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);

            if ($unit == "M") {
                return $miles;
            } else if ($unit == "N") {
                return ($miles * 0.8684);
            } else {
                return ($miles * 1.609344);
            }
        }
    }
}
