<?php /* phpcs:ignore WordPress.Files.FileName.InvalidClassFileName */
/**
 * Image generator
 *
 * @since 1.0.0
 * @package MyOwnCDN
 */

namespace MyOwnCDN\Generators;

use MyOwnCDN\Models\CDN;
use MyOwnCDN\Traits\HasRegex;

/**
 * ImageGenerator class.
 */
class ImageGenerator {
	use HasRegex;

	/**
	 * Original image object from DOM.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected string $image = '';

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
	 * Processed image object.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected string $processed = '';

	/**
	 * Selected provider.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected string $provider = '';

	/**
	 * Class constructor.
	 *
	 * @since 1.0.0
	 *
	 * @param string $provider Image provider.
	 */
	public function __construct( string $provider ) {
		$this->provider = $provider;
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
		$this->image = $image;
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
	 * Process the image and return.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_processed(): string {
		if ( ! empty( $this->src ) && ! $this->is_source_tag() ) {
			$this->process( $this->src );
		}

		if ( ! empty( $this->srcset ) ) {
			$this->process( $this->srcset );
		}

		return empty( $this->processed ) ? $this->image : $this->processed;
	}

	/**
	 * Is this a <source> tag?
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	private function is_source_tag(): bool {
		return 'source' === substr( $this->image, 1, 6 );
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

		$generator = CDN::url()->using( $this->provider, 'image' );

		foreach ( $urls[0] as $link ) {
			$src = $generator->origin( $link )()->url;

			if ( $src ) {
				$this->processed = str_replace( $link, $src, empty( $this->processed ) ? $this->image : $this->processed );
			}
		}
	}
}
