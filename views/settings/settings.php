<?php
/**
 * Settings view
 *
 * @package Settings
 *
 * Adds the plugin settings page and associated views
 */

namespace PL\Views;

defined('ABSPATH') || exit();

/**
 * Class Settings
 *
 * Hooks to the settings API to add settings views and menu
 */
class Settings {
    public static function init()
    {
        if (is_admin()) {
            add_action('admin_menu', [ __CLASS__, 'add_settings_page' ]);
        }
    }

    public static function add_settings_page()
    {
        add_options_page(__('Post Location Settings', 'post_location'), __('Post Location', 'post_location'), 'manage_options', 'post-location', [ __CLASS__, 'output_settings_page' ]);
    }

    public static function output_settings_page()
    {
        ?>
        <h2><?php esc_html_e('Post Location Settings', 'post_location'); ?></h2>
        <form action="options.php" method="post">
            <?php settings_fields('pl_options_group'); ?>
            <?php do_settings_sections('post-location'); ?>
            <input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e('Save', 'post_location'); ?>" />
        </form>
        <?php
    }
}

require_once __DIR__ . '/settings.functions.php';
