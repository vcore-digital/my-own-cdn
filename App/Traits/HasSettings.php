<?php /* phpcs:ignore WordPress.Files.FileName.InvalidClassFileName */
/**
 * Settings trait
 *
 * @since 1.0.0
 * @package MyOwnCDN
 */

namespace MyOwnCDN\Traits;

use MyOwnCDN\Responses\StatusResponse;

/**
 * HasSettings trait.
 */
trait HasSettings {
	/**
	 * Settings array.
	 *
	 * @since 1.0.0
	 * @var array|string[]
	 */
	private array $settings = array(
		'provider' => '',
		'status'   => '',
		'zone'     => '',
	);

	/**
	 * Set a setting.
	 *
	 * @since 1.0.0
	 *
	 * @param string $key   Setting key.
	 * @param mixed  $value Setting value.
	 */
	public function set_setting( string $key, $value ): void {
		if ( ! array_key_exists( $key, $this->settings ) ) {
			return;
		}

		$settings = get_option( 'moc-settings', array() );

		$settings[ $key ] = $value;

		update_option( 'moc-settings', $settings, false );
	}

	/**
	 * Get a setting value.
	 *
	 * @since 1.0.0
	 *
	 * @param string $key Setting key.
	 *
	 * @return mixed
	 */
	public function get_setting( string $key ) {
		$settings = get_option( 'moc-settings', array() );
		return $settings[ $key ] ?? false;
	}

	/**
	 * Update settings from response.
	 *
	 * @since 1.0.0
	 *
	 * @param StatusResponse $response API response.
	 *
	 * @return void
	 */
	public function save_status( StatusResponse $response ): void {
		// Status must not be empty.
		if ( empty( $response->status ) ) {
			return;
		}

		$this->set_setting( 'provider', $response->provider );
		$this->set_setting( 'status', $response->status );
		$this->set_setting( 'zone', $response->zone );
	}
}
