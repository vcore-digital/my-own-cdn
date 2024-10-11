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
		if ( array_key_exists( $name, $this->providers ) ) {
			return new $this->providers[ $name ]();
		}

		// Look for a custom provider.
		$provider_method = 'create_' . strtolower( $name ) . '_provider';

		if ( method_exists( $this, $provider_method ) ) {
			return $this->{$provider_method}();
		}

		/* translators: %s: provider name */
		throw new InvalidArgumentException( sprintf( esc_html__( 'Provider [%s] is not supported.', 'my-own-cdn' ), esc_html( $name ) ) );
	}
}
