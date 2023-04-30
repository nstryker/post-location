<?php
/**
 * Geocoder services
 *
 * @package Geocoder
 *
 * Handles requests to GoogleMaps API through Geocoder
 */

namespace PL\Service;

use Geocoder\Query\GeocodeQuery;
use Geocoder\Query\ReverseQuery;

defined('ABSPATH') || exit();

/**
 * Class Geocoder
 *
 * Uses Geocoder to request geotags from GoogleMaps API
 */
class Geocoder {

    /**
     * Geocoder object
     * 
     * @var $geocoder
     * 
     * Stores the Geocoder object for use in methods
     */
    private static $geocoder = null;

    public static function init()
    {
    }

    private static function geocoder()
    {
        if (is_null(self::$geocoder)) {
            try {
                $httpClient     = new \Http\Adapter\Guzzle6\Client();
                $provider       = new \Geocoder\Provider\GoogleMaps\GoogleMaps($httpClient, null, pl_get_api_key());
                self::$geocoder = new \Geocoder\StatefulGeocoder($provider, 'en');
            } catch (\Exception $e) {
                return new \WP_Error('exception', $e->getMessage());
            }
        }

        return self::$geocoder;
    }

    public static function get_geocode($location)
    {
        $geocoder = self::geocoder();

        if (is_wp_error($geocoder)) {
            return $geocoder;
        }

        try {
            $result = $geocoder->geocodeQuery(GeocodeQuery::create($location));

            if ($result->isEmpty()) {
                return new \WP_Error('exception', sprintf(__('Location "%s" not found.', 'post_location'), $location));
            }

            return $result;
        } catch (\Exception $exception) {
            return new \WP_Error('exception', $exception->getMessage());
        }
    }
}

require_once __DIR__ . '/geocoder.functions.php';
