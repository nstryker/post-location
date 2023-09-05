<?php
/**
 * Utility methods
 *
 * @class       Utils
 * @version     0.1.0
 * @package     Post_Location/Classes/
 */

namespace Post_Location;

defined( 'ABSPATH' ) || exit();

/**
 * Utils class
 */
final class Utils {
	/**
	 * Gets the plugin url.
	 *
	 * @return string
	 */
	public static function plugin_url() {
		return untrailingslashit( plugins_url( '/', PLUGIN_FILE ) );
	}

	/**
	 * Gets the plugin path.
	 *
	 * @return string
	 */
	public static function plugin_path() {
		return untrailingslashit( plugin_dir_path( PLUGIN_FILE ) );
	}

	/**
	 * Tests the request type
	 *
	 * @param  string $type admin, ajax, cron or frontend.
	 * @return bool
	 */
	public static function is_request( $type ) {

		switch ( $type ) {
			case 'admin':
				return is_admin();
			case 'ajax':
				return defined( 'DOING_AJAX' ) && DOING_AJAX;
			case 'cron':
				return defined( 'DOING_CRON' ) && DOING_CRON;
			case 'frontend':
				return ( ! is_admin() || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) && ( ! defined( 'DOING_CRON' ) || ! DOING_CRON );
		}
	}
}
