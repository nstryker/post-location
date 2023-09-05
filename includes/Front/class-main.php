<?php
/**
 * Handles front hooks.
 *
 * @class       Front
 * @version     0.1.0
 * @package     Post_Location/Classes/
 */

namespace Post_Location\Front;

defined( 'ABSPATH' ) || exit();

/**
 * Front main class
 */
final class Main {
	/**
	 * Constructor
	 */
	public static function hooks() {
		Assets::hooks();
		Map::hooks();
	}
}
