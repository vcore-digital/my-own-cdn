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

		$parser = new Parser();
		$parser->init();
	}
}
