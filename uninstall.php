<?php
/**
 * Handles behaviors when the plugin is uninstalled.
 *
 * @package     Post_Location/Uninstaller
 * @version     0.1.0
 */

defined( 'WP_UNINSTALL_PLUGIN' ) || exit();

/**
 * Remove API key.
 */
$options = get_option( 'pl_options' );

unset( $options['api_key'] );
update_option( 'pl_options', $options );
