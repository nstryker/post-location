<?php
/**
 * Handles post meta box
 *
 * @class       Meta
 * @version     1.0.0
 * @package     Post_Location/Classes/
 */

namespace Post_Location\Admin;

defined( 'ABSPATH' ) || exit();

/**
 * Admin main class
 */
final class Meta {
	/**
	 * Constructor
	 */
	public static function hooks() {
		add_action( 'add_meta_boxes', array( __CLASS__, 'add_meta_box' ) );
	}

	/**
	 * Sets up the post meta box.
	 *
	 * @return void
	 */
	public static function add_meta_box() {
		if ( \Post_Location\Admin\Settings::get_api_key() ) {
			add_meta_box( 'pl-location', __( 'Post Location', 'post-location' ), array( __CLASS__, 'meta_box_view' ), 'post', 'side' );
		}
	}

	/**
	 * Displays the post meta box.
	 *
	 * @param WP_Post $post Post object.
	 * @return void
	 */
	public static function meta_box_view( $post ) {
		$location = \Post_Location\Meta::get_meta( $post, 'location' );
		$user_id  = get_current_user_id();
		$error    = get_transient( "pl_error_{$post->ID}_{$user_id}" );
		?>
		<div class="components-base-control">
			<div class="components-base-control__field">
				<label class="components-base-control__label" for="pl-location-input">
					<?php esc_html_e( 'Street Address', 'post-location' ); ?>
				</label>
				<textarea class="components-textarea-control__input" id="pl-location-input" name="pl_location"><?php echo esc_attr( $location ); ?></textarea>
			</div>
		</div>
		<?php wp_nonce_field( 'pl_location', 'pl_location_nonce' ); ?>

		<?php if ( $error ) : ?>
			<div>
				<?php echo esc_html( $error ); ?>
			</div>
			<?php delete_transient( "pl_error_{$post->ID}_{$user_id}" ); ?>
		<?php endif; ?>

		<?php
		// TODO: Render map with valid location.
	}
}
