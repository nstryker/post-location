<?php
/**
 * Handles settings page
 *
 * @class       Settings
 * @version     1.0.0
 * @package     Post_Location/Classes/
 */

namespace Post_Location\Admin;

defined( 'ABSPATH' ) || exit();

/**
 * Admin main class
 */
final class Settings {
	/**
	 * Constructor
	 */
	public static function hooks() {
		add_action( 'admin_init', array( __CLASS__, 'register_settings' ) );
		add_action( 'admin_menu', array( __CLASS__, 'add_settings_settings_page' ) );
	}

	/**
	 * Sets up plugin settings page.
	 *
	 * @return void
	 */
	public static function register_settings() {
		register_setting( 'pl_options_group', 'pl_options', array( __CLASS__, 'validate_inputs' ) );
		add_settings_section( 'pl_api_settings', __( 'API Settings', 'post-location' ), array( __CLASS__, 'settings_intro_view' ), 'post-location' );
		add_settings_field( 'pl-api-key', 'API Key', array( __CLASS__, 'settings_inputs_view' ), 'post-location', 'pl_api_settings' );
	}

	/**
	 * Validates plugin settings before saving.
	 *
	 * @param array $inputs Post ID.
	 * @return array
	 */
	public static function validate_inputs( $inputs ) {
		$api_key = isset( $inputs['api_key'] ) ? trim( $inputs['api_key'] ) : false;

		if ( $api_key ) {
			if ( ! is_string( $api_key ) ) {
				$api_key = null;
			}
			// TODO: Test API key.

			$inputs['api_key'] = $api_key;
		}

		return $inputs;
	}

	/**
	 * Displays the settings page intro.
	 *
	 * @return void
	 */
	public static function settings_intro_view() {
		$google_api_url = 'https://developers.google.com/console';

		printf( '<p>%s<a href="%s" target="_blank">%s</a></p>', esc_html__( 'Fetch your Google API key from the ', 'post-location' ), esc_url( $google_api_url ), esc_html__( 'Google API page', 'post-location' ) );
	}

	/**
	 * Displays the settings page inputs.
	 *
	 * @return void
	 */
	public static function settings_inputs_view() {
		$api_key = self::get_api_key();

		printf(
			'<input id="pl-api-key" name="pl_options[api_key]" type="text" value="%s" />',
			esc_attr( $api_key )
		);
	}

	/**
	 * Retrieves the saved API key.
	 *
	 * @return string
	 */
	public static function get_api_key() {
		$options = get_option( 'pl_options' );
		$api_key = isset( $options['api_key'] ) ? $options['api_key'] : '';

		return $api_key;
	}

	/**
	 * Adds the Post Location settings page.
	 *
	 * @return void
	 */
	public static function add_settings_settings_page() {
		add_options_page( __( 'Post Location Settings', 'post-location' ), __( 'Post Location', 'post-location' ), 'manage_options', 'post-location', array( __CLASS__, 'settings_page_view' ) );
	}

	/**
	 * Displays the Post Location settings page.
	 *
	 * @return void
	 */
	public static function settings_page_view() {
		?>

		<h2><?php esc_html_e( 'Post Location Settings', 'post-location' ); ?></h2>
		<form action="options.php" method="post">
			<?php settings_fields( 'pl_options_group' ); ?>
			<?php do_settings_sections( 'post-location' ); ?>
			<input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e( 'Save', 'post-location' ); ?>" />
		</form>

		<?php
	}
}
