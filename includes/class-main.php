<?php
/**
 * Main class.
 *
 * @package  Post_Location
 * @version  0.1.0
 */

namespace Post_Location;

defined( 'ABSPATH' ) || exit();

/**
 * Base Plugin class holding generic functionality
 */
final class Main {
	/**
	 * Sets the minimum required versions for the plugin.
	 * Be sure to also update `phpcs.xml`
	 */
	const PLUGIN_REQUIREMENTS = array(
		'php_version' => '7.3',
		'wp_version'  => '5.6',
	);

	/**
	 * Constructor
	 */
	public static function bootstrap() {
		if ( self::check_plugin_requirements() ) {
			Meta::hooks();

			if ( Utils::is_request( 'admin' ) ) {
				Admin\Main::hooks();
			}

			if ( Utils::is_request( 'frontend' ) ) {
				Front\Main::hooks();
			}

			// Starter for a future Gutenberg block: Block::hooks().

			// TODO: Set up localisation: self::load_plugin_textdomain().
		}
	}

	/**
	 * Checks all plugin requirements. If run in admin context also adds a notice.
	 *
	 * @return boolean
	 */
	private static function check_plugin_requirements() {
		$errors = array();
		global $wp_version;

		if ( ! version_compare( PHP_VERSION, self::PLUGIN_REQUIREMENTS['php_version'], '>=' ) ) {
			$errors[] = sprintf(
				/* translators: %s is replaced with the required PHP version and should not be translated */
				esc_html__( 'Post Location requires a minimum PHP version of %s.', 'post-location' ),
				self::PLUGIN_REQUIREMENTS['php_version']
			);
		}

		if ( ! version_compare( $wp_version, self::PLUGIN_REQUIREMENTS['wp_version'], '>=' ) ) {
			$errors[] = sprintf(
				/* translators: %s is replaced with the required WP version and should not be translated */
				esc_html__( 'Post Location requires a minimum WordPress version of %s.', 'post-location' ),
				self::PLUGIN_REQUIREMENTS['wp_version']
			);
		}

		if ( ! empty( $errors ) ) {
			if ( Utils::is_request( 'admin' ) ) {
				add_action(
					'admin_notices',
					function () use ( $errors ) {
						?>
						<div class="notice notice-error">
							<?php
							foreach ( $errors as $error ) {
								echo '<p>' . esc_html( $error ) . '</p>';
							}
							?>
						</div>
						<?php
					}
				);

				return;
			}

			return false;
		}

		return true;
	}

	/**
	 * Loads Localisation files.
	 *
	 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
	 *
	 * Locales found in:
	 *      - WP_LANG_DIR/post-location/post-location-LOCALE.mo
	 *      - WP_LANG_DIR/plugins/post-location-LOCALE.mo
	 */
	private static function load_plugin_textdomain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'post-location' );

		load_textdomain( 'post-location', WP_LANG_DIR . '/post-location/post-location-' . $locale . '.mo' );
		load_plugin_textdomain( 'post-location', false, plugin_basename( __DIR__ ) . '/i18n/languages' );
	}
}
