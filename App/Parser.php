<?php /* phpcs:ignore WordPress.Files.FileName.InvalidClassFileName */
/**
 * Page parser functionality
 *
 * Responsible for parsing the page for images and replacing them with correct CDN URLs.
 *
 * @since 1.0.0
 * @package MyOwnCDN
 */

namespace MyOwnCDN;

use MyOwnCDN\Traits\HasRegex;

/**
 * Parser class.
 */
class Parser {
	use HasRegex;

	/**
	 * Init the module.
	 *
	 * @since 1.1.0
	 */
	public function init() {
		if ( ! $this->can_run() ) {
			return;
		}

		add_action( 'template_redirect', array( $this, 'output_buffering' ), 1 );
	}

	/**
	 * Can we run the frontend functionality?
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	private function can_run(): bool {
		if ( is_admin() || wp_doing_ajax() || wp_doing_cron() || is_customize_preview() ) {
			return false;
		}

		return true;
	}

	/**
	 * Turn on output buffering.
	 *
	 * @since 1.0.0
	 */
	public function output_buffering() {
		ob_start( array( $this, 'replace_images' ) );
	}

	/**
	 * Output buffer callback.
	 *
	 * @since 1.0.0
	 *
	 * @param string $buffer Contents of the output buffer.
	 *
	 * @return string
	 */
	public function replace_images( string $buffer ): string {
		$images = $this->get_images( $buffer );

		if ( empty( $images ) ) {
			return $buffer;
		}

		foreach ( $images[0] as $key => $image_dom ) {
			$image = CDN::image()
				->dom( $image_dom )
				->src( $images[1][ $key ] )
				->srcset( $images[2][ $key ] );

			$buffer = str_replace( $image_dom, $image->get_processed(), $buffer );
		}

		return $buffer;
	}

	/**
	 * Get images from source code.
	 *
	 * @since 1.0.0
	 *
	 * @param string $buffer Output buffer.
	 *
	 * @return array
	 */
	private function get_images( string $buffer ): array {
		if ( ! preg_match( $this->get_body_content(), $buffer, $body ) ) {
			return array(); // No content found.
		}

		if ( preg_match_all( $this->get_all_images(), $body[0], $images ) ) {
			return $images;
		}

		return array();
	}
}
