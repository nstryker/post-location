<?php
/**
 * Handles Geocoder interactions.
 *
 * @class       Geocoder
 * @version     0.1.0
 * @package     Post_Location/Classes/
 */

namespace Post_Location;

defined( 'ABSPATH' ) || exit();

use Geocoder\Query\GeocodeQuery;
use Geocoder\Query\ReverseQuery;

/**
 * Geocoder main class
 */
final class Geocoder {
	/**
	 * Contains the Geocoder object.
	 *
	 * @var object
	 */
	private static $geocoder = null;

	/**
	 * Initializes a Geocoder object.
	 *
	 * @return object|WP_Error
	 */
	private static function get_geocoder() {
		if ( is_null( self::$geocoder ) ) {
			try {
				$api_key        = \Post_Location\Admin\Settings::get_api_key();
				$http_client    = new \Http\Adapter\Guzzle6\Client();
				$provider       = new \Geocoder\Provider\GoogleMaps\GoogleMaps( $http_client, null, $api_key );
				self::$geocoder = new \Geocoder\StatefulGeocoder( $provider, 'en' );
			} catch ( \Exception $e ) {
				return new \WP_Error( 'exception', $e->getMessage() );
			}
		}

		return self::$geocoder;
	}

	/**
	 * Gets the Geocode for a given location.
	 *
	 * @param string $location User input location.
	 * @return string|WP_Error
	 */
	public static function get_geocode( $location ) {
		$geocoder = self::get_geocoder();

		if ( ! is_wp_error( $geocoder ) ) {
			try {
				$result = $geocoder->geocodeQuery( GeocodeQuery::create( $location ) );

				if ( $result->isEmpty() ) {
					$geocoder = new \WP_Error(
						'exception',
						sprintf(
							/* translators: %s is the user input location and should not be translated. */
							esc_html__( 'Location "%s" not found.', 'post-location' ),
							$location
						)
					);
				}

				$geocoder = $result;
			} catch ( \Exception $exception ) {
				$geocoder = new \WP_Error( 'exception', $exception->getMessage() );
			}
		}

		return $geocoder;
	}
}
