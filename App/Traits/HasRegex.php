<?php /* phpcs:ignore WordPress.Files.FileName.InvalidClassFileName */
/**
 * Regular expression trait
 *
 * @since 1.0.0
 * @package MyOwnCDN
 */

namespace MyOwnCDN\Traits;

trait HasRegex {
	/**
	 * Regex to get content from the body tag.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_body_content(): string {
		return '/(?=<body).*<\/body>/is';
	}

	/**
	 * Get all img and source elements.
	 *
	 * Executing this regex, will return an array with the following keys:
	 * 0: Original image
	 * 1: Image src attribute value
	 * 2: Image srcset attribute value
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_all_images(): string {
		return '/<(?:img|source)\b(?>\s+(?:src=[\'"]([^\'"]*)[\'"]|srcset=[\'"]([^\'"]*)[\'"])|[^\s>]+|\s+)*>/i';
	}

	/**
	 * Match URLs that start with:
	 * - http:
	 * - https:
	 * - // (but only if this string is at the beginning of a word or after whitespace)
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_valid_urls(): string {
		return '/https?:\S+|(?<!\S)\/\/\S+/i';
	}
}
