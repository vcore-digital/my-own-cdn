<?php /* phpcs:ignore WordPress.Files.FileName.InvalidClassFileName */
/**
 * API class
 *
 * This class defines all code for registering, authenticating and managing API keys.
 *
 * @since 1.0.0
 * @package MyOwnCDN
 */

namespace MyOwnCDN\Api;

use Exception;
use stdClass;

/**
 * API class.
 *
 * @since 1.0.0
 */
class API extends Request {
	/**
	 * Test API token endpoint.
	 *
	 * @since 1.0.0
	 *
	 * @return stdClass
	 * @throws Exception API issues.
	 */
	public function login(): stdClass {
		$this->set_method( 'GET' );
		$this->set_endpoint( 'user' );

		return $this->process_response( $this->request() );
	}
}
