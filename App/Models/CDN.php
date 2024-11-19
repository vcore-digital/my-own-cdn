<?php /* phpcs:ignore WordPress.Files.FileName.InvalidClassFileName */
/**
 * CDN functionality for the plugin
 *
 * @since 1.0.0
 * @package MyOwnCDN
 */

namespace MyOwnCDN\Models;

use MyOwnCDN\Generators\ImageGenerator;
use MyOwnCDN\Generators\URLGenerator;

/**
 * CDN class.
 */
class CDN {
	/**
	 * Generate a CDN URL.
	 *
	 * @since 1.0.0
	 *
	 * @return URLGenerator
	 */
	public static function url(): URLGenerator {
		return new URLGenerator();
	}

	/**
	 * Generate an image element object.
	 *
	 * @since 1.0.0
	 *
	 * @return ImageGenerator
	 */
	public static function image(): ImageGenerator {
		return new ImageGenerator();
	}

	/**
	 * Save provider.
	 *
	 * @since 1.0.0
	 *
	 * @param string $provider Provider ID.
	 */
	public static function set_provider( string $provider ): void {
		$settings = get_option( 'moc-settings', array() );

		$settings['provider'] = $provider;

		update_option( 'moc-settings', $settings, false );
	}

	/**
	 * Get provider.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function get_provider(): string {
		$settings = get_option( 'moc-settings', array() );

		return $settings['provider'] ?? '';
	}
}
