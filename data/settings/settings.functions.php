<?php
/**
 * Settings data functions
 *
 * @package Settings
 *
 * Data functions for settings fields
 */

use PL\Data\Settings;

defined('ABSPATH') || exit();

if (!function_exists('pl_get_api_key')) {
    /**
     * Returns the markup for the settings page API section intro
     *
     * @return string
     */
    function pl_get_api_key()
    {
        return apply_filters('pl_get_api_key', Settings::get_api_key());
    }
}
