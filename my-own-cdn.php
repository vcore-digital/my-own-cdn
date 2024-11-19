<?php
/**
 * My Own CDN - CDN made simple for effortless performance
 *
 * @link              https://myowncdn.com
 * @since             1.0.0
 * @package           MyOwnCDN
 *
 * @wordpress-plugin
 * Plugin Name:       MyOwnCDN: CDN made simple
 * Plugin URI:        https://myowncdn.com
 * Description:       CDN made simple for effortless performance.
 * Version:           1.0.0
 * Author:            vCore Digital
 * Author URI:        https://vcore.au
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       my-own-cdn
 * Domain Path:       /languages
 * Network:           true
 */

namespace MyOwnCDN;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

const VERSION = '1.0.0';
define( 'MY_OWN_CDN_PATH', plugin_dir_path( __FILE__ ) );
define( 'MY_OWN_CDN_URL', plugin_dir_url( __FILE__ ) );

spl_autoload_register( __NAMESPACE__ . '\autoload' );

/**
 * Autoload plugin classes.
 *
 * @param string $class_name Class to load.
 */
function autoload( string $class_name ): void {
	$length = strlen( __NAMESPACE__ );

	if ( 0 !== strncmp( __NAMESPACE__, $class_name, $length ) ) {
		return; // Not a supported class.
	}

	$rel_class = substr( $class_name, $length );
	$rel_class = str_replace( '\\', DIRECTORY_SEPARATOR, $rel_class );

	$file = MY_OWN_CDN_PATH . 'App/' . $rel_class . '.php';

	if ( file_exists( $file ) ) {
		require_once $file;
	}
}

Core::instance()->run();
