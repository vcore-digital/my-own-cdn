<?php /* phpcs:ignore WordPress.Files.FileName.InvalidClassFileName */
/**
 * Bunny.net provider
 *
 * @since 1.0.0
 * @package MyOwnCDN
 */

namespace MyOwnCDN\Providers;

use MyOwnCDN\Contracts\Provider;
use MyOwnCDN\Responses\ProviderResponse;

/**
 * Bunny class.
 */
class Bunny extends BaseProvider implements Provider {
	/**
	 * Takes the origin URL and converts it to the provider supported URL.
	 *
	 * @since 1.0.0
	 *
	 * @param string $origin The origin URL.
	 *
	 * @return ProviderResponse
	 */
	public function url( string $origin ): ProviderResponse {
		$image = str_replace( $this->domain, $this->zone, $origin );

		return new ProviderResponse( $origin, $image );
	}
}
