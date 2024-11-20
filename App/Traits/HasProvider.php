<?php /* phpcs:ignore WordPress.Files.FileName.InvalidClassFileName */
/**
 * Functionality that allows the class (usually a generator) to use a provider.
 *
 * @since 1.0.0
 * @package MyOwnCDN
 */

namespace MyOwnCDN\Traits;

use MyOwnCDN\Contracts\Provider;
use MyOwnCDN\Generators\URLGenerator;
use MyOwnCDN\Manager;

/**
 * HasProvider trait.
 */
trait HasProvider {
	/**
	 * The provider instance.
	 *
	 * @var Provider
	 */
	protected Provider $provider;

	/**
	 * Set the provider and asset type.
	 *
	 * @since 1.0.0
	 *
	 * @param string $provider Provider name.
	 * @param string $zone     CDN zone.
	 *
	 * @return URLGenerator|HasProvider
	 */
	public function using( string $provider, string $zone ): self {
		$this->provider = ( new Manager() )->resolve( $provider );
		$this->provider->set_zone( $zone );

		return $this;
	}
}
