<?php
/**
 * Geocoder service functions
 *
 * @package Geocoder
 *
 * Service functions for sending requests to GoogleMaps API via Geocoder
 */

use PL\Service\Geocoder;

defined('ABSPATH') || exit();

if (!function_exists('pl_get_location_geocode')) {
    /**
     * Gets the geocode for a given location.
     *
     * @param  string $location A location string (ie street address).
     * @return string
     */
    function pl_get_location_geocode($location)
    {
        return apply_filters('pl_get_location_geocode', Geocoder::get_geocode($location), $location);
    }
}
