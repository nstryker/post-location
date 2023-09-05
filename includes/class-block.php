<?php
/**
 * Handles Gutenberg blocks registration.
 *
 * @class       Block
 * @version     0.1.0
 * @package     Post_Location/Classes/
 */

namespace Post_Location;

defined( 'ABSPATH' ) || exit();

/**
 * Block main class
 */
final class Block {
	/**
	 * Constructor
	 */
	public static function hooks() {
		add_action( 'init', array( __CLASS__, 'register_blocks' ) );
	}

	/**
	 * Registers Gutenberg blocks
	 *
	 * @return void
	 */
	public static function register_blocks() {
		$blocks = apply_filters( 'post_location_blocks', array() );

		foreach ( $blocks as $key => $block ) {
			$block_name = is_string( $block ) ? $block : $key;
			$args       = is_string( $block ) ? array() : $block;

			if ( is_admin() ) {
				self::register_admin( $block_name );
			}

			self::register( $block_name, $args );
		}
	}

	/**
	 * Registers a new block for admin
	 *
	 * @param string $block Block name.
	 * @return void
	 */
	public static function register_admin( $block = '' ) {
		$block_name = empty( $block ) ? PREFIX : $block;
		$block_path = $block . '/';

		if ( ! file_exists( Utils::plugin_path() . '/assets/build/' . $block_path . 'index.asset.php' ) ) {
			return;
		}

		$asset_block = include Utils::plugin_path() . '/assets/build/' . $block_path . 'index.asset.php';

		wp_register_script(
			'post-location-' . $block_name . '-blocks',
			Utils::plugin_url() . '/assets/build/' . $block_path . 'index.js',
			$asset_block['dependencies'],
			$asset_block['version'],
			true
		);
	}

	/**
	 * Registers a new block
	 *
	 * @param string $block Block name.
	 * @param array  $args  Block arguments.
	 * @return void
	 */
	public static function register( $block = '', $args = array() ) {
		$block_name = empty( $block ) ? PREFIX : $block;

		// Sets frontend styles.
		$styles = array();
		if ( ! empty( $args['styles'] ) ) {
			array_push( $styles, $args['styles'] );
		}

		// Sets frontend script.
		$script = '';
		if ( ! empty( $args['script'] ) ) {
			$script = $args['script'];
		}

		// Sets editor styles.
		$editor_style = 'post-location-' . $block_name . '-blocks';
		if ( ! empty( $args['editor_style'] ) ) {
			$editor_style = $args['editor_style'];
		}

		register_block_type(
			'post-location/' . $block_name,
			array(
				'style'         => $styles,
				'script'        => $script,
				'editor_style'  => $editor_style,
				'editor_script' => 'post-location-' . $block_name . '-blocks',
			)
		);
	}
}
