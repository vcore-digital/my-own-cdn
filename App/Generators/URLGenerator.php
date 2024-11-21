<?php /* phpcs:ignore WordPress.Files.FileName.InvalidClassFileName */
/**
 * URL Generator
 *
 * Generates a URL using a selected provider.
 *
 * @since 1.0.0
 * @package MyOwnCDN
 */

namespace MyOwnCDN\Generators;

use MyOwnCDN\Responses\URLResponse;
use MyOwnCDN\Traits\HasProvider;
use MyOwnCDN\Traits\HasRegex;

/**
 * URLGenerator class.
 */
class URLGenerator {
	use HasProvider;
	use HasRegex;

	/**
	 * Origin URL.
	 *
	 * @since 1.0.0
	 *
	 * @var string|null
	 */
	protected ?string $origin = null;

	/**
	 * Processed image.
	 *
	 * @since 1.0.0
	 *
	 * @var string|null
	 */
	protected ?string $processed = null;

	/**
	 * Image src attribute value.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected string $src = '';

	/**
	 * Image srcset attribute value.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected string $srcset = '';

	/**
	 * Perform the URL generation.
	 *
	 * @since 1.0.0
	 *
	 * @return URLResponse
	 */
	public function __invoke(): URLResponse {
		$this->processed = null;

		if ( ! empty( $this->src ) && ! $this->is_source_tag() ) {
			$this->process( $this->src );
		}

		if ( ! empty( $this->srcset ) ) {
			$this->process( $this->srcset );
		}

		return new URLResponse( $this->processed );
	}

	/**
	 * Set the DOM element for the image.
	 *
	 * @since 1.0.0
	 *
	 * @param string $image The image DOM object.
	 *
	 * @return $this
	 */
	public function dom( string $image ): self {
		$this->origin = $image;

		return $this;
	}

	/**
	 * Set the image source (src attribute).
	 *
	 * @since 1.0.0
	 *
	 * @param string $src Src attribute.
	 *
	 * @return $this
	 */
	public function src( string $src ): self {
		$this->src = $src;

		return $this;
	}

	/**
	 * Set the image srcset attribute and return the processed element.
	 *
	 * @since 1.0.0
	 *
	 * @param string $srcset Srcset attribute.
	 *
	 * @return $this
	 */
	public function srcset( string $srcset ): self {
		$this->srcset = $srcset;

		return $this;
	}

	/**
	 * Is this a <source> tag?
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	private function is_source_tag(): bool {
		return 'source' === substr( $this->origin, 1, 6 );
	}

	/**
	 * Process image element.
	 *
	 * @since 1.0.0
	 *
	 * @param string $content Which attribute to process.
	 */
	private function process( string $content ) {
		preg_match_all( $this->get_valid_urls(), $content, $urls );
		if ( ! is_array( $urls ) || empty( $urls[0] ) ) {
			return;
		}

		foreach ( $urls[0] as $link ) {
			$response = $this->provider->url( $link );

			if ( $response->cdn_url ) {
				$this->processed = str_replace( $link, $response->cdn_url, empty( $this->processed ) ? $this->origin : $this->processed );
			}
		}
	}
}
