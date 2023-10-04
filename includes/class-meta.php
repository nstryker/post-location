<?php
/**
 * Handles post meta interactions.
 *
 * @class       Meta
 * @version     0.1.0
 * @package     Post_Location/Classes/
 */

namespace Post_Location;

defined( 'ABSPATH' ) || exit();

/**
 * Meta main class
 */
final class Meta {
	/**
	 * Constructor
	 */
	public static function hooks() {
		add_action( 'save_post', array( __CLASS__, 'save_location' ) );
	}

	/**
	 * Sets required meta data when a post is saved.
	 *
	 * @param int $post_id Post ID.
	 * @return void
	 */
	public static function save_location( $post_id ) {
		$data  = wp_unslash( $_POST );
		$nonce = isset( $data['pl_location_nonce'] ) ? wp_verify_nonce( $data['pl_location_nonce'], 'pl_location' ) : false;

		if ( $nonce && isset( $data['pl_location'] ) ) {
			$location = sanitize_text_field( $data['pl_location'] );

			if ( self::get_meta( $post_id, 'location' ) !== $location ) {
				if ( '' === trim( $location ) ) {
					self::set_meta( $post_id, 'geocode', false );
					self::set_meta( $post_id, 'location', false );
				} else {
					$geocode = Geocoder::get_geocode( $location );

					if ( is_wp_error( $geocode ) ) {
						$user_id = get_current_user_id();
						$message = sprintf(
							/* translators: %s is replaced with the error message and should not be translated */
							__( 'Error: %s', 'post-location' ),
							$geocode->get_error_message()
						);

						set_transient( "pl_error_{$post_id}_{$user_id}", $message, 60 );
					} else {
						self::set_meta( $post_id, 'geocode', $geocode );
						self::set_meta( $post_id, 'location', $location );
					}
				}
			}
		}
	}

	/**
	 * Gets the meta value for the given key. Returns false if not found.
	 *
	 * @param int|WP_Post $post Post ID or object.
	 * @param string      $key  Key for the requested meta.
	 * @return mixed
	 */
	public static function get_meta( $post, $key ) {
		$post   = get_post( $post );
		$result = false;

		if ( null !== $post ) {
			$key    = sprintf( 'pl_%s', $key );
			$result = get_post_meta( $post->ID, $key, true );
		}

		return $result;
	}

	/**
	 * Sets a post meta value.
	 *
	 * @param int|WP_Post $post Post ID or object.
	 * @param string      $key  The required meta.
	 * @param mixed       $value  The required meta.
	 * @return string|false
	 */
	public static function set_meta( $post, $key, $value ) {
		$post = get_post( $post );

		if ( null === $post ) {
			return false;
		}

		$key = sprintf( 'pl_%s', $key );

		return update_post_meta( $post->ID, $key, $value );
	}
}
