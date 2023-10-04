<?php
/**
 * Handles map embed
 *
 * @class       Map
 * @version     1.0.0
 * @package     Post_Location/Classes/
 */

namespace Post_Location\Front;

defined( 'ABSPATH' ) || exit();

/**
 * Admin main class
 */
final class Map {
	/**
	 * Constructor
	 */
	public static function hooks() {
		add_filter( 'the_content', array( __CLASS__, 'output_map' ) );
	}

	/**
	 * Adds map to the end of the post content.
	 *
	 * @param string $content Post content.
	 * @return string
	 */
	public static function output_map( $content ) {
		if ( is_singular( 'post' ) ) {
			$post     = get_post();
			$geocode  = \Post_Location\Meta::get_meta( $post, 'geocode' );
			$location = \Post_Location\Meta::get_meta( $post, 'location' );

			if ( $geocode && $location ) {
				$coordinates = $geocode->first()->getCoordinates();
				$map_script  = sprintf(
					'function initMap() {
						const location = { lat: %1$s, lng: %2$s };
						const map = new google.maps.Map(document.getElementById("pl-map"), {
							zoom: 12,
							center: location,
						});

						const marker = new google.maps.Marker({
							position: location,
							map: map,
							title: "%3$s",
						});
					}

					window.initMap = initMap;',
					$coordinates->getLatitude(),
					$coordinates->getLongitude(),
					esc_html( $location )
				);
				ob_start();
				?>

				<p>
				<?php
				printf(
					/* translators: Placeholders come from inputs and should not be translated. */
					esc_html__( 'Location: %1$s (%2$s,%3$s)', 'post-location' ),
					esc_html( $location ),
					$coordinates->getLatitude(), // phpcs:ignore
					$coordinates->getLongitude() // phpcs:ignore
				);
				?>
				</p>
				<div id="pl-map"></div>
				<?php
				wp_print_inline_script_tag( $map_script );

				$content .= ob_get_clean();
			}
		}

		return $content;
	}
}
