<?php
/**
 * Post Location bootstrap file
 *
 * @since             0.0.1
 * @package           Post_Location
 *
 * @wordpress-plugin
 * Plugin Name: Post Location
 * Plugin URI:  https://github.com/nstryker/post-location
 * Description: Allows posts to be geotagged with a location displayed on a map in the post content.
 * Version:     0.1.3
 * Author:      Nathan Stryker
 * Author URI:  http://nstryker.com/
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: post-location
 * Domain Path: /i18n/languages
 */

namespace Post_Location;

defined( 'ABSPATH' ) || exit();

const VERSION     = '0.1.3';
const PLUGIN_FILE = __FILE__;

/**
 * Autoloads packages. Prompts for composer install is the autoloader isn't found.
 */
try {
	require __DIR__ . '/vendor/autoload.php';
} catch ( \Exception $e ) {
	$composer_error = array(
		/* translators: %1$s is replaced with "composer install" and should not be translated, %2$s is replaced with the plugin path */
		'message'   => esc_html__( 'Your installation of Post Location plugin is incomplete. Please run %1$s within the %2$s directory.', 'post-location' ),
		'command'   => 'composer install',
		'directory' => esc_html( str_replace( ABSPATH, '', __DIR__ ) ),
	);

	if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		error_log( // phpcs:ignore
			sprintf(
				$composer_error['message'],
				'`' . $composer_error['command'] . '`',
				'`' . $composer_error['directory'] . '`'
			)
		);
	}

	add_action(
		'admin_notices',
		function () {
			?>
			<div class="notice notice-error">
				<p>
					<?php
					printf(
						$composer_error['message'], // phpcs:ignore
						'<code>' . $composer_error['command'] . '</code>', // phpcs:ignore
						'<code>' . $composer_error['directory'] . '</code>' // phpcs:ignore
					);
					?>
				</p>
			</div>
			<?php
		}
	);

	return;
}

use Pablo_Pacheco\WP_Namespace_Autoloader\WP_Namespace_Autoloader;
$autoloader = new WP_Namespace_Autoloader(
	array(
		'directory'        => __DIR__,
		'namespace_prefix' => 'Post_Location',
		'classes_dir'      => 'includes',
	)
);
$autoloader->init();

Main::bootstrap();
