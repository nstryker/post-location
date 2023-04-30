<?php
/**
 * Geocode data functions
 *
 * @package Geocode
 *
 * Data functions for post geocodes
 */

use PL\Data\Geocode;

defined('ABSPATH') || exit();

if (!function_exists('pl_get_geocode')) {
    /**
     * Gets the location for a given post or ID.
     *
     * @param  int|WP_Post $post Post ID or WP_Post object.
     * @return string
     */
    function pl_get_geocode($post)
    {
        return apply_filters('pl_get_geocode', Geocode::get_geocode($post), $post);
    }
}

if (!function_exists('pl_set_geocode')) {
    /**
     * Sets the location for a given post or ID.
     *
     * @param  int|WP_Post $post Post ID or WP_Post object.
     * @param  string      $geocode String indicating the location.
     * @return boolean
     */
    function pl_set_geocode($post, $geocode)
    {
        return apply_filters('pl_set_geocode', Geocode::set_geocode($post, $geocode), $post, $geocode);
    }
}
