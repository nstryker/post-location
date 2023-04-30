<?php
/**
 * Location data
 *
 * @package Location
 *
 * Allows access to store and retrieve location data, processes post meta field
 */

namespace PL\Data;

defined('ABSPATH') || exit();

/**
 * Class Location
 *
 * Stores and retrieves location data for posts, processes post meta field
 */
class Location {

    public static function init()
    {
        add_action('save_post', [ __CLASS__, 'save_location' ]);
    }

    public static function save_location($post_id)
    {
        $data  = wp_unslash($_POST);
        $nonce = isset($data['pl_location_nonce']) ? wp_verify_nonce($data['pl_location_nonce'], 'pl_location' ) : false;

        if ($nonce && isset($data['pl_location'])) {
            $location = sanitize_text_field($data['pl_location']);

            if (pl_get_location($post_id) !== $location) {
                if ('' === trim($location)) {
                    pl_set_location($post_id, false);
                    pl_set_geocode($post_id, false);
                } else {
                    $geocode = pl_get_location_geocode($location);

                    if (is_wp_error($geocode)) {
                        $message = sprintf(__('Error: %s', 'post_location'), $geocode->get_error_message());
                        $user_id = get_current_user_id();

                        set_transient("pl_error_{$post_id}_{$user_id}", $message, 60);
                    } else {
                        pl_set_location($post_id, $location);
                        pl_set_geocode($post_id, $geocode);
                    }
                }
            }
        }
    }

    public static function get_location($post)
    {
        $post   = get_post($post);
        $result = false;

        if (null === $post) {
            return false;
        }

        return get_post_meta($post->ID, 'pl_location', true);
    }

    public static function set_location($post, $location)
    {
        $post = get_post($post);

        if (null === $post) {
            return false;
        }

        return update_post_meta($post->ID, 'pl_location', $location);
    }
}

require_once __DIR__ . '/location.functions.php';
