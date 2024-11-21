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
	private function __construct() {
		add_action( 'admin_init', array( $this, 'set_cron_schedule' ) );
	}

	/**
	 * Run the plugin.
	 *
	 * @since 1.0.0
	 */
	public function run() {
		$admin = new Admin();

		add_action( 'my_own_cdn_status', array( $admin, 'update_status' ) );

		$parser = new Parser();
		$parser->init();
	}

	/**
	 * Remove scheduled cron event.
	 *
	 * @since 1.0.0
	 */
	public static function remove_cron() {
		$timestamp = wp_next_scheduled( 'my_own_cdn_status' );
		wp_unschedule_event( $timestamp, 'my_own_cdn_status' );
	}

	/**
	 * Schedule a cron to make sure that CDN is always synced with the API.
	 *
	 * @since 1.0.0
	 */
	public function set_cron_schedule() {
		if ( ! wp_next_scheduled( 'my_own_cdn_status' ) ) {
			wp_schedule_event( time() + DAY_IN_SECONDS, 'daily', 'my_own_cdn_status' );
		}
	}
}
