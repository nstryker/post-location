<?php
/**
 * Registers frontend assets.
 *
 * @class       FrontAssets
 * @version     0.1.0
 * @package     post_Post_Locationlocation/Classes/
 */

namespace Post_Location\Front;

defined( 'ABSPATH' ) || exit();

use Post_Location\Utils;

/**
 * Frontend assets class
 */
final class Assets {
	/**
	 * Constructor
	 */
	public static function hooks() {
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_styles' ) );
		add_action( 'wp_footer', array( __CLASS__, 'output_scripts' ) );
	}

	/**
	 * Adds map to the end of the post content.
	 *
	 * @return void
	 */
	public static function enqueue_styles() {
		$api_key = \Post_Location\Admin\Settings::get_api_key();
		$post    = get_post();
		$geocode = \Post_Location\Meta::get_meta( $post, 'geocode' );

		if ( $api_key && $geocode ) {
			$file_path = Utils::plugin_url() . '/assets/css/front/post-location.css';
			wp_register_style( 'pl-map-styles', $file_path, array(), \Post_Location\VERSION );
			wp_enqueue_style( 'pl-map-styles' );
		}
	}

	/**
	 * Prints the external script to the frontend.
	 *
	 * @return void
	 */
	public static function output_scripts() {
		$api_key = \Post_Location\Admin\Settings::get_api_key();

		if ( is_singular( 'post' ) && $api_key ) {
			$script_src = sprintf(
				'https://maps.googleapis.com/maps/api/js?key=%s&callback=initMap',
				$api_key
			);
			wp_print_script_tag(
				array(
					'id'    => 'pl-map-scripts',
					'src'   => esc_url( $script_src ),
					'async' => true,
				)
			);
		}
	}
}
