<?php
/**
 * Settings view functions
 *
 * @package Settings
 *
 * View functions for settings functions in Data\Settings\Settings
 */

use PL\Views\Settings;

defined('ABSPATH') || exit();

if (!function_exists('pl_api_intro')) {
    /**
     * Echos the markup for the settings page API section intro
     *
     * @printf string
     */
    function pl_api_intro()
    {
        $google_api_url = 'https://developers.google.com/console';

        printf('<p>%s<a href="%s" target="_blank">%s</a></p>', esc_html__('Fetch your Google API key from the '), esc_url($google_api_url), esc_html__('Google API page', 'post_location'));
    }
}

if (!function_exists('pl_api_inputs')) {
    /**
     * Echos the markup for the settings page API inputs
     *
     * @printf string
     */
    function pl_api_inputs()
    {
        $api_key = pl_get_api_key();

        printf('<input id="pl_api_key" name="pl_options[api_key]" type="text" value="%s" />', esc_attr($api_key));
    }
}
