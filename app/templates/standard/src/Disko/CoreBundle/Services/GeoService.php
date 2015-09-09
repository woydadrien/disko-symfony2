<?php

namespace Disko\CoreBundle\Services;

/**
 * GeoService
 */
class GeoService extends BaseService
{
    /**
     * @param $address
     * @return array gps coordinate from address
     */
    public function location($address)
    {
        for ($attemps = 0; $attemps < 3; $attemps++) {
            $curl = curl_init();
            curl_setopt ($curl, CURLOPT_URL, 'http://maps.googleapis.com/maps/api/geocode/json?sensor=false&address='.urlencode($address));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            $result = curl_exec ($curl);
            curl_close ($curl);
            $result = json_decode($result, true);
            if ($result && $result['status'] == 'OK' && count($result['results']) > 0) {
                return $result['results'][0]['geometry']['location'];
            } elseif ($result['status'] == 'OVER_QUERY_LIMIT') {
                //https://developers.google.com/maps/documentation/business/articles/usage_limits?hl=FR
                sleep(2.0);
            }
        }

        return array(
            'lat' => 0,
            'lng' => 0,
        );
    }
}
