<?php /* phpcs:ignore WordPress.Files.FileName.InvalidClassFileName */
/**
 * Core functionality for the plugin
 *
 * @since 1.0.0
 * @package MyOwnCDN
 */

namespace MyOwnCDN;

/**
 * Core class.
 */
class Core {
	/**
	 * Use the singleton pattern to store the plugin instance.
	 *
	 * @since 1.0.0
	 *
	 * @var null|Core
	 */
	private static ?Core $instance = null;

	/**
	 * Get class instance.
	 *
	 * @since 1.0.0
	 *
	 * @return Core
	 */
	public static function instance(): Core {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Class constructor.
	 *
	 * @since 1.0.0
	 */
	private function __construct() {}

	/**
	 * Run the plugin.
	 *
	 * @since 1.0.0
	 */
	public function run() {
		// Init admin functionality.
		// Init frontend functionality.
		$images = array(
			'https://example.com/image1.jpg',
			'https://example.com/image2.jpg',
			'https://example.com/image3.jpg',
		);

		$generator = CDN::url()->using( 'bunny', 'image' );
		foreach ( $images as $image ) {
			$cdn_url = $generator->origin( $image )();
			$new_url = $cdn_url->url;
		}

		//$my_own_cdn = CDN::url()->using( 'bunny', 'image' )->origin( 'https://example.com/image.jpg' );
		//$cdn_url    = $my_own_cdn()->url;
	}
}
