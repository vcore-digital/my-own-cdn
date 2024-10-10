<?php
/**
 * Core functionality for the plugin
 *
 * @since 1.0.0
 * @package My_Own_CDN
 */

namespace My_Own_CDN;

/**
 * Core class.
 */
final class Core {
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
	}
}
