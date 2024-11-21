<?php /* phpcs:ignore WordPress.Files.FileName.InvalidClassFileName */
/**
 * Provider base class
 *
 * @since 1.0.0
 * @package MyOwnCDN
 */

namespace MyOwnCDN\Providers;

/**
 * BaseProvider class.
 */
class BaseProvider {
	/**
	 * CDN zone.
	 *
	 * @var string
	 */
	protected string $zone;

	/**
	 * Current site domain.
	 *
	 * @var string
	 */
	protected string $domain;

	/**
	 * BaseProvider constructor.
	 */
	public function __construct() {
		$this->domain = wp_parse_url( get_site_url(), PHP_URL_HOST );
	}

	/**
	 * Set the CDN zone.
	 *
	 * @param string $zone CDN zone.
	 *
	 * @return self
	 */
	public function set_zone( string $zone ): self {
		$this->zone = $zone;

		return $this;
	}
}
