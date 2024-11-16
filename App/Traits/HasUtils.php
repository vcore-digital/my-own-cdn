<?php /* phpcs:ignore WordPress.Files.FileName.InvalidClassFileName */
/**
 * Utilities trait
 *
 * @since 1.0.0
 * @package MyOwnCDN
 */

namespace MyOwnCDN\Traits;

/**
 * HasUtils trait.
 */
trait HasUtils {
	/**
	 * Get plugin slug.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_slug(): string {
		return 'my-own-cdn';
	}

	/**
	 * Get page URL.
	 *
	 * @since 1.0.0
	 *
	 * @param string $page  Page type.
	 *
	 * @return string
	 */
	public function get_url( string $page = 'plugin' ): string {
		switch ( $page ) {
			case 'register':
				return 'https://myowncdn.com/register';
			case 'site-login':
				return 'https://myowncdn.com/login';
			case 'plugin':
			default:
				return menu_page_url( $this->get_slug(), false );
		}
	}
}
