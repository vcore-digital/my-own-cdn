<?php /* phpcs:ignore WordPress.Files.FileName.InvalidClassFileName */
/**
 * User model
 *
 * @since 1.0.0
 * @package MyOwnCDN
 */

namespace MyOwnCDN\Models;

/**
 * User class.
 */
class User {
	/**
	 * Set API token value.
	 *
	 * @since 1.0.0
	 *
	 * @param string $value API token.
	 */
	public static function set_token( string $value ): void {
		update_option( 'moc-api-token', $value, false );
	}

	/**
	 * Get API token value.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function get_token(): string {
		$token = get_option( 'moc-api-token', '' );

		if ( defined( 'MY_OWN_CDN_API_TOKEN' ) && MY_OWN_CDN_API_TOKEN ) {
			$token = MY_OWN_CDN_API_TOKEN;
		}

		return $token;
	}

	/**
	 * Check if API token is present.
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	public static function has_api_token(): bool {
		return ! empty( self::get_token() );
	}
}
