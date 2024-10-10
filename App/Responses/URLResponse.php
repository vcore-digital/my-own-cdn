<?php /* phpcs:ignore WordPress.Files.FileName.InvalidClassFileName */
/**
 * Response for URL generation
 *
 * Will contain the generated CDN URL and other information.
 *
 * @since 1.0.0
 * @package MyOwnCDN
 */

namespace MyOwnCDN\Responses;

/**
 * URLResponse class.
 */
class URLResponse {
	/**
	 * Readonly property for the generated URL.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public string $url;

	/**
	 * Class constructor.
	 *
	 * @since 1.0.0
	 *
	 * @param string $cdn_url The generated CDN URL.
	 */
	public function __construct( string $cdn_url ) {
		$this->url = $cdn_url;
	}
}
