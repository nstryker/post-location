<?php
/**
 * Map view
 *
 * @package Map
 *
 * Displays the map and necessary scripts and styles on posts
 */

namespace PL\Views;

defined('ABSPATH') || exit();

/**
 * Class Map
 *
 * Adds map output to the post content as well as scripts and styles
 */
class Map {

    public static function init()
    {
        add_filter('the_content', [ __CLASS__, 'output_map' ]);
        add_action('wp_enqueue_scripts', [ __CLASS__, 'enqueue_scripts' ]);
        add_action('wp_footer', [ __CLASS__, 'output_scripts' ]);
    }

    public static function output_map($content)
    {
        if (is_singular('post')) {
            $post     = get_post();
            $geocode  = pl_get_geocode($post);
            $location = pl_get_location($post);

            if ($geocode && $location) {
                $coordinates   = $geocode->first()->getCoordinates();
                $location_text = sprintf(__('Location: %1$s (%2$s,%3$s)', 'post_location'), esc_html($location), $coordinates->getLatitude(), $coordinates->getLongitude());
                $map_script    = sprintf('function initMap() {
                    const location = { lat: %1$s, lng: %2$s };
                    const map = new google.maps.Map(document.getElementById("map"), {
                        zoom: 12,
                        center: location,
                    });

                    const marker = new google.maps.Marker({
                        position: location,
                        map: map,
                        title: "%3$s",
                    });
                }

                window.initMap = initMap;', $coordinates->getLatitude(), $coordinates->getLongitude(), esc_html($location));

                $content = sprintf('%s<p>%s</p><div id="map"></div>%s', $content, $location_text, wp_get_inline_script_tag($map_script));
            }
        }

        return $content;
    }

    public static function enqueue_scripts()
    {
        $api_key = pl_get_api_key();

        if (is_singular('post') && $api_key) {
            wp_enqueue_style('pl_map_styles', plugin_dir_url(__FILE__) . 'map.css', [], 1.0);
        }
    }

    public static function output_scripts()
    {
        $api_key = pl_get_api_key();

        if (is_singular('post') && $api_key) {
            wp_print_script_tag([
                'id'    => 'pl_map_styles',
                'src'   => esc_url(sprintf('https://maps.googleapis.com/maps/api/js?key=%s&callback=initMap', $api_key)),
                'async' => true,
            ]);
        }
    }
}
