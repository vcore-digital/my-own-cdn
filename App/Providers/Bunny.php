<?php /* phpcs:ignore WordPress.Files.FileName.InvalidClassFileName */

namespace MyOwnCDN\Providers;

use MyOwnCDN\Contracts\Provider;
use MyOwnCDN\Responses\ProviderResponse;

/**
 * Bunny class.
 */
class Bunny implements Provider {
	/**
	 * The asset type.
	 *
	 * @var string
	 */
	protected string $type;

	/**
	 * Set the asset type.
	 *
	 * @param string $type The asset type (image, video, etc...).
	 *
	 * @return self
	 */
	public function set_type( string $type ): self {
		$this->type = $type;

		return $this;
	}

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
		return new ProviderResponse(
			$origin,
			$this->type,
			'https://bunnycdn'
		);
	}
}
