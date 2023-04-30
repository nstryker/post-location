<?php
/**
 * Geocode data
 *
 * @package Geocode
 *
 * Allows access to store and retrieve geocode data
 */

namespace PL\Data;

defined('ABSPATH') || exit();

/**
 * Class Geocode
 *
 * Stores and retrieves geocode data for posts
 */
class Geocode {

    public static function init()
    {
    }

    public static function get_geocode($post)
    {
        $post   = get_post($post);
        $result = false;

        if (null === $post) {
            return false;
        }

        return get_post_meta($post->ID, 'pl_geocode', true);
    }

    public static function set_geocode($post, $geocode)
    {
        $post = get_post($post);

        if (null === $post) {
            return false;
        }

        return update_post_meta($post->ID, 'pl_geocode', $geocode);
    }
}

require_once __DIR__ . '/geocode.functions.php';
