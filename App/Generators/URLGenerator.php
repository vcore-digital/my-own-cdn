<?php /* phpcs:ignore WordPress.Files.FileName.InvalidClassFileName */
/**
 * URL Generator
 *
 * Generates a URL using a selected provider.
 *
 * @since 1.0.0
 * @package MyOwnCDN
 */

namespace MyOwnCDN\Generators;

use MyOwnCDN\Responses\ProviderResponse;
use MyOwnCDN\Responses\URLResponse;
use MyOwnCDN\Traits\HasProvider;

/**
 * URLGenerator class.
 */
class URLGenerator {
	use HasProvider;

	/**
	 * Origin URL.
	 *
	 * @since 1.0.0
	 *
	 * @var string|null
	 */
	protected ?string $origin = null;

	/**
	 * CDN URL.
	 *
	 * @since 1.0.0
	 *
	 * @var string|null
	 */
	protected ?string $cdn_url = null;

	/**
	 * Perform the URL generation.
	 *
	 * @since 1.0.0
	 *
	 * @return URLResponse
	 */
	public function __invoke(): URLResponse {
		$this->send_provider_request();
		return new URLResponse( $this->cdn_url );
	}

	/**
	 * Set the origin URL.
	 *
	 * @since 1.0.0
	 *
	 * @param string $url Origin URL.
	 *
	 * @return $this
	 */
	public function origin( string $url ): self {
		// TODO: Check if valid URL provided.
		$this->origin = $url;

		return $this;
	}

	/**
	 * Forward the request to the provider.
	 *
	 * @since 1.0.0
	 *
	 * @return ProviderResponse
	 */
	protected function send_provider_request(): ProviderResponse {
		// TODO: improve how we pass over the image URL. Best to pass over something like an ImageRequest object that
		// contains the URL, attachment ID, size, etc...
		$response = $this->provider->url( $this->origin );

		// Similar to the above, use state to store the response message object.
		$this->cdn_url = $response->cdn_url;

		return $response;
	}
}
