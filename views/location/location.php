<?php
/**
 * Location view
 *
 * @package Location
 *
 * Adds the post location meta box and necessary styles
 */

namespace PL\Views;

defined('ABSPATH') || exit();

/**
 * Class Location
 *
 * Hooks to the meta box API to add location field as well as styles
 */
class Location {

    public static function init()
    {
        if (is_admin()) {
            add_action('add_meta_boxes', [ __CLASS__, 'add_meta_box' ]);
            add_action('admin_print_styles', [ __CLASS__, 'enqueue_style' ]);
        }
    }

    public static function add_meta_box()
    {
        if (pl_get_api_key()) {
            add_meta_box('pl_location', __('Post Location', 'post_location'), [ __CLASS__, 'output_location' ], 'post', 'side');
        }
    }

    public static function output_location($post)
    {
        $location = pl_get_location($post);
        $user_id  = get_current_user_id();
        $error    = get_transient("pl_error_{$post->ID}_{$user_id}"); ?>
        <label for="pl_location_input"><?php esc_html_e('Street Address', 'post_location'); ?></label>
        <input class="postbox" id="pl_location_input" name="pl_location" value="<?php echo esc_attr($location); ?>" />
        <?php wp_nonce_field('pl_location', 'pl_location_nonce'); ?>
        <?php
        // TODO: Render map with valid location
        if ($error) {
            printf('<div>%s</div>', esc_html($error));
            delete_transient("pl_error_{$post->ID}_{$user_id}");
        }
    }

    public static function enqueue_style()
    {
        global $typenow;
        if ('post' === $typenow) {
            wp_enqueue_style('pl_meta_box_styles', plugin_dir_url(__FILE__) . 'location.css', [], 1.0);
        }
    }
}
