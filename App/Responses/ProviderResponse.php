<?php /* phpcs:ignore WordPress.Files.FileName.InvalidClassFileName */
/**
 * Provider response object
 *
 * @since 1.0.0
 * @package MyOwnCDN
 */

namespace MyOwnCDN\Responses;

/**
 * ProviderResponse class.
 */
class ProviderResponse {
	/**
	 * Readonly property for the generated URL.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public string $origin;

	/**
	 * Readonly property for the CDN URL.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public string $cdn_url;

	/**
	 * Class constructor.
	 *
	 * @since 1.0.0
	 *
	 * @param string $origin  Origin URL.
	 * @param string $cdn_url CDN URL.
	 */
	public function __construct( string $origin, string $cdn_url ) {
		$this->origin  = $origin;
		$this->cdn_url = $cdn_url;
	}
}
