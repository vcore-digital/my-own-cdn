<?php /* phpcs:ignore WordPress.Files.FileName.InvalidClassFileName */
/**
 * The file that defines the image object
 *
 * When parsing a page, we will do a lot of image manipulations, and it's easier to dedicate an object for each image,
 * rather than try to maintain the data with vars.
 *
 * @since 1.0.0
 * @package MyOwnCDN
 */

namespace MyOwnCDN;

use MyOwnCDN\Generators\ImageGenerator;

/**
 * Image class.
 */
class Image {
	/**
	 * Generate an image element object.
	 *
	 * @since 1.0.0
	 *
	 * @return ImageGenerator
	 */
	public static function element(): ImageGenerator {
		return new ImageGenerator();
	}
}
