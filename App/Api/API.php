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
	 * Get URL parameters.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	private function get_url_params(): array {
		return array(
			'site' => site_url(),
		);
	}

	/**
	 * Get status.
	 *
	 * @since 1.0.0
	 *
	 * @return stdClass
	 * @throws Exception API issues.
	 */
	public function status(): stdClass {
		$this->set_method( 'POST' );
		$this->set_endpoint( 'status' );

		return $this->process_response( $this->request( $this->get_url_params() ) );
	}
}
