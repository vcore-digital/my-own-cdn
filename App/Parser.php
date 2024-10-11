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

/**
 * Parser class.
 */
class Parser {
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

		// TODO: get the provider from the settings.
		$generator = CDN::url()->using( 'bunny', 'image' );

		foreach ( $images[0] as $key => $image_dom ) {
			/**
			 * Reference
			 *
			 * @var string $image_dom         Image DOM object.
			 * @var string $images[1][ $key ] Image src value.
			 * @var string $images[2][ $key ] Image srcset value.
			 */

			$cdn    = $generator->origin( $images[1][ $key ] )();
			$buffer = str_replace( $image_dom, $cdn->url, $buffer );
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
		if ( preg_match( '/(?=<body).*<\/body>/is', $buffer, $body ) ) {
			$pattern = '/<(?:img|source)\b(?>\s+(?:src=[\'"]([^\'"]*)[\'"]|srcset=[\'"]([^\'"]*)[\'"])|[^\s>]+|\s+)*>/i';
			if ( preg_match_all( $pattern, $body[0], $images ) ) {
				return $images;
			}
		}

		return array();
	}
}
