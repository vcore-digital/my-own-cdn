<?php /* phpcs:ignore WordPress.Files.FileName.InvalidClassFileName */
/**
 * CDN status generator
 *
 * @since 1.0.0
 * @package MyOwnCDN
 */

namespace MyOwnCDN\Generators;

use MyOwnCDN\Traits\HasSettings;

/**
 * StatusGenerator class.
 */
class StatusGenerator {
	use HasSettings;

	/**
	 * Get the status message.
	 *
	 * @return string
	 */
	public function message(): string {
		$status = $this->get_setting( 'status' );

		if ( empty( $status ) || 'setup' === $status ) {
			return esc_html__( 'Setup required', 'my-own-cdn' );
		}

		if ( 'enabled' === $status ) {
			return esc_html__( 'CDN is active', 'my-own-cdn' );
		}

		if ( 'processing' === $status ) {
			return esc_html__( 'CDN activating. Some providers can take up to 30 minutes to perform initial zone setup. Click "Refresh status" link below to update the status.', 'my-own-cdn' );
		}

		if ( 'failed' === $status ) {
			return esc_html__( 'CDN activation failed', 'my-own-cdn' );
		}

		return esc_html__( 'Unknown status', 'my-own-cdn' );
	}
}
