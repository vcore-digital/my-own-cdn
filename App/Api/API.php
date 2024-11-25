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
use MyOwnCDN\Responses\StatusResponse;
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
	 * @return StatusResponse
	 * @throws Exception API issues.
	 */
	public function status(): StatusResponse {
		$this->set_method( 'POST' );
		$this->set_endpoint( 'status' );

		$response = $this->process_response( $this->request( $this->get_url_params() ) );

		return new StatusResponse(
			$response->provider ?? '',
			$response->status ?? '',
			$response->zone ?? '',
		);
	}

	/**
	 * Clear cache.
	 *
	 * @since 1.0.0
	 *
	 * @return stdClass
	 * @throws Exception API issues.
	 */
	public function clear_cache(): stdClass {
		$this->set_method( 'DELETE' );
		$this->set_endpoint( 'cache' );

		return $this->process_response( $this->request( $this->get_url_params() ) );
	}

	/**
	 * Enable CDN provider.
	 *
	 * @since 1.0.0
	 *
	 * @param string $provider Provider.
	 *
	 * @return StatusResponse
	 * @throws Exception API issues.
	 */
	public function enable( string $provider ): StatusResponse {
		$this->set_method( 'POST' );
		$this->set_endpoint( 'enable' );

		$params = array_merge(
			array(
				'provider' => $provider,
			),
			$this->get_url_params()
		);

		$response = $this->process_response( $this->request( $params ) );

		return new StatusResponse(
			$response->provider ?? '',
			$response->status ?? '',
			$response->zone ?? '',
		);
	}
}
