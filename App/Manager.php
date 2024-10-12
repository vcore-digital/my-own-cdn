<?php /* phpcs:ignore WordPress.Files.FileName.InvalidClassFileName */
/**
 * Manage provider resolution
 *
 * Decides which provider to use based on the name.
 *
 * @since 1.0.0
 * @package MyOwnCDN
 */

namespace MyOwnCDN;

use InvalidArgumentException;
use MyOwnCDN\Contracts\Provider;
use MyOwnCDN\Providers\Bunny;

/**
 * Manager class.
 */
class Manager {
	/**
	 * List of supported providers.
	 *
	 * @since 1.0.0
	 *
	 * @var array()
	 */
	private array $providers = array(
		'bunny' => Bunny::class,
	);

	/**
	 * Cache of resolved providers.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	private array $cache = array();

	/**
	 * Resolve name to a provider.
	 *
	 * @since 1.0.0
	 *
	 * @param string $name Provider name.
	 *
	 * @throws InvalidArgumentException If the provider is not supported.
	 * @return Provider
	 */
	public function resolve( string $name ): Provider {
		// Cache the provider, in case the initialization is expensive.
		if ( isset( $this->cache[ $name ] ) ) {
			return $this->cache[ $name ];
		}

		// Check registered providers.
		if ( array_key_exists( $name, $this->providers ) ) {
			$this->cache[ $name ] = new $this->providers[ $name ]();
			return $this->cache[ $name ];
		}

		// Look for a custom provider.
		$provider_method = 'create_' . strtolower( $name ) . '_provider';

		if ( method_exists( $this, $provider_method ) ) {
			$this->cache[ $name ] = $this->{$provider_method}();
			return $this->cache[ $name ];
		}

		/* translators: %s: provider name */
		throw new InvalidArgumentException( sprintf( esc_html__( 'Provider [%s] is not supported.', 'my-own-cdn' ), esc_html( $name ) ) );
	}
}
