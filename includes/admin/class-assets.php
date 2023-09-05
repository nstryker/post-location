<?php
/**
 * Registers admin assets.
 *
 * @class       AdminAssets
 * @version     1.0.0
 * @package     Post_Location/Classes/
 */

namespace Post_Location\Admin;

defined( 'ABSPATH' ) || exit();

use Post_Location\Utils;

/**
 * Admin assets class
 */
final class Assets {
	/**
	 * Constructor
	 */
	public static function hooks() {
		add_action( 'admin_print_styles', array( __CLASS__, 'enqueue_style' ) );
	}

	/**
	 * Adds styles for the admin.
	 *
	 * @return void
	 */
	public static function enqueue_style() {
		global $typenow;
		$api_key = \Post_Location\Admin\Settings::get_api_key();

		if ( 'post' === $typenow && $api_key ) {
			$file_path = Utils::plugin_url() . '/assets/css/admin/post-location.css';
			wp_register_style( 'pl-meta-box-styles', $file_path, array(), \Post_Location\VERSION );
			wp_enqueue_style( 'pl-meta-box-styles' );
		}
	}
}
