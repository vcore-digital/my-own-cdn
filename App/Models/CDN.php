<?php /* phpcs:ignore WordPress.Files.FileName.InvalidClassFileName */
/**
 * CDN functionality for the plugin
 *
 * @since 1.0.0
 * @package MyOwnCDN
 */

namespace MyOwnCDN\Models;

use MyOwnCDN\Generators\ImageGenerator;
use MyOwnCDN\Generators\StatusGenerator;
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
	 * @param string $provider Image provider.
	 *
	 * @return ImageGenerator
	 */
	public static function image( string $provider ): ImageGenerator {
		return new ImageGenerator( $provider );
	}

	/**
	 * Generate a status message.
	 *
	 * @since 1.0.0
	 *
	 * @return StatusGenerator
	 */
	public static function status(): StatusGenerator {
		return new StatusGenerator();
	}
}
