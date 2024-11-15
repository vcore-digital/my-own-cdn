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
		$image = $this->replace_cdn_url( $origin );

		return new ProviderResponse(
			$origin,
			$this->type,
			$image
		);
	}

	/**
	 * Add the CDN domain to image URLs.
	 *
	 * @since 1.0.0
	 *
	 * @param string $image_url Image URL.
	 *
	 * @return string
	 */
	private function replace_cdn_url( string $image_url ): string {
		$domain = wp_parse_url( get_site_url(), PHP_URL_HOST );
		// TODO: this should be a setting.
		return str_replace( $domain, 'bunny.net', $image_url );
	}
}
