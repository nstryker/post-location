<?php
/**
 * Location data functions
 *
 * @package Location
 *
 * Data functions for post location
 */

use PL\Data\Location;

defined('ABSPATH') || exit();

if (!function_exists('pl_get_location')) {
    /**
     * Gets the location for a given post or ID.
     *
     * @param  int|WP_Post $post Post ID or WP_Post object.
     * @return string
     */
    function pl_get_location($post)
    {
        return apply_filters('pl_get_location', Location::get_location($post), $post);
    }
}

if (!function_exists('pl_set_location')) {
    /**
     * Sets the location for a given post or ID.
     *
     * @param  int|WP_Post $post Post ID or WP_Post object.
     * @param  string      $location String indicating the location.
     * @return boolean|WP_Error
     */
    function pl_set_location($post, $location)
    {
        return apply_filters('pl_set_location', Location::set_location($post, $location), $post, $location);
    }
}
