<?php /* phpcs:ignore WordPress.Files.FileName.InvalidClassFileName */
/**
 * Response for status API calls
 *
 * @since 1.0.0
 * @package MyOwnCDN
 */

namespace MyOwnCDN\Responses;

/**
 * StatusResponse class.
 */
class StatusResponse {
	/**
	 * Readonly property for the CDN provider.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public string $provider;

	/**
	 * Readonly property for the CDN status.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public string $status;

	/**
	 * Readonly property for CDN zone.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public string $zone;

	/**
	 * Class constructor.
	 *
	 * @since 1.0.0
	 *
	 * @param string $provider CDN provider.
	 * @param string $status   CDN status.
	 * @param string $zone     CDN zone.
	 */
	public function __construct( string $provider, string $status, string $zone ) {
		$this->provider = $provider;
		$this->status   = $status;
		$this->zone     = $zone;
	}
}
