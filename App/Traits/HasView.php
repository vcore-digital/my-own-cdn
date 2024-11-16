<?php /* phpcs:ignore WordPress.Files.FileName.InvalidClassFileName */
/**
 * Views trait
 *
 * @since 1.0.0
 * @package MyOwnCDN
 */

namespace MyOwnCDN\Traits;

use MyOwnCDN\Models\User;

trait HasView {
	/**
	 * Render admin menu.
	 *
	 * @since 1.0.0
	 */
	public function render_page(): void {
		$view = $this->get_view();

		if ( empty( $view ) ) {
			if ( User::has_api_token() ) {
				$view = 'setup';
			} else {
				$view = 'api-key';
			}
		}

		$this->view( $view );
	}

	/**
	 * Load an admin view.
	 *
	 * @param string $file  View file name.
	 *
	 * @return void
	 */
	protected function view( string $file ) {
		$view = MY_OWN_CDN_PATH . 'App/Views/' . $file . '.php';

		if ( ! file_exists( $view ) ) {
			return;
		}

		ob_start();
		include $view;
		echo ob_get_clean(); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */
	}

	/**
	 * Get view page.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	protected function get_view(): string {
		$view = filter_input( INPUT_GET, 'view', FILTER_UNSAFE_RAW );
		return sanitize_text_field( $view );
	}
}
