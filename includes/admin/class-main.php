<?php
/**
 * Handles admin hooks.
 *
 * @class       Admin
 * @version     1.0.0
 * @package     Post_Location/Classes/
 */

namespace Post_Location\Admin;

defined( 'ABSPATH' ) || exit();

/**
 * Admin main class
 */
final class Main {
	/**
	 * Constructor
	 */
	public static function hooks() {
		Assets::hooks();
		Meta::hooks();
		Settings::hooks();

		add_action( 'current_screen', array( __CLASS__, 'conditional_includes' ) );
	}

	/**
	 * Includes admin files conditionally.
	 *
	 * @return void
	 */
	public static function conditional_includes() {
		$screen = get_current_screen();

		if ( ! $screen ) {
			return;
		}

		switch ( $screen->id ) {
			case 'dashboard':
			case 'options-permalink':
			case 'users':
			case 'user':
			case 'profile':
			case 'user-edit':
		}
	}
}
