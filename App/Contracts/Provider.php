<?php /* phpcs:ignore WordPress.Files.FileName.InvalidClassFileName */
/**
 * Contract for the provider role
 *
 * Defines the methods that a provider must implement.
 *
 * @since 1.0.0
 * @package MyOwnCDN
 */

namespace MyOwnCDN\Contracts;

use MyOwnCDN\Responses\ProviderResponse;

/**
 * Driver interface.
 */
interface Provider {
	/**
	 * Set the asset type.
	 *
	 * @param string $type The asset type (image, video, etc...).
	 *
	 * @return Provider
	 */
	public function set_type( string $type ): Provider;

	/**
	 * Takes the origin URL and converts it to the provider supported URL.
	 *
	 * @since 1.0.0
	 *
	 * @param string $origin The origin URL.
	 *
	 * @return ProviderResponse
	 */
	public function url( string $origin ): ProviderResponse;
}
