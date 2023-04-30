<?php
/**
 * Settings data
 *
 * @package Settings
 *
 * Adds the settings registration, processing and functions
 */

namespace PL\Data;

defined('ABSPATH') || exit();

/**
 * Class Settings
 *
 * Registers the settings fields and processing
 */
class Settings {

    public static function init()
    {
        if (is_admin()) {
            add_action('admin_init', [ __CLASS__, 'register_settings' ]);
        }
    }

    public static function register_settings()
    {
        register_setting('pl_options_group', 'pl_options', [ __CLASS__, 'validate_inputs' ]);
        add_settings_section('pl_api_settings', __('API Settings', 'post_location'), 'pl_api_intro', 'post-location');
        add_settings_field('pl_api_key', 'API Key', 'pl_api_inputs', 'post-location', 'pl_api_settings');
    }

    public static function validate_inputs($inputs)
    {
        $api_key = isset($inputs['api_key']) ? trim($inputs['api_key']) : false;

        if ($api_key) {
            if (!is_string($api_key)) {
                $api_key = null;
            }
            // TODO: Test API key

            $inputs['api_key'] = $api_key;
        }

        return $inputs;
    }

    public static function get_api_key()
    {
        $options = get_option('pl_options');
        $api_key = isset($options['api_key']) ? $options['api_key'] : '';

        return $api_key;
    }
}

require_once __DIR__ . '/settings.functions.php';
