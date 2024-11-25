<?php /* phpcs:ignore WordPress.Files.FileName.InvalidClassFileName */
/**
 * Abstract API class
 *
 * This class defines all code necessary to communicate with the API.
 *
 * @since 1.0.0
 * @package MyOwnCDN
 */

namespace MyOwnCDN\Api;

use Exception;
use MyOwnCDN\Models\User;
use stdClass;

/**
 * Abstract Request class.
 *
 * @since 1.0.0
 */
abstract class Request {
	/**
	 * API URL.
	 *
	 * @since 1.0.0
	 * @var string $api_url API URL.
	 */
	protected string $api_url = 'https://myowncdn.com/api/cdn/';

	/**
	 * Endpoint for API call.
	 *
	 * @since 1.0.0
	 * @var string $endpoint API endpoint.
	 */
	private string $endpoint = '';

	/**
	 * Body for API call.
	 *
	 * @since 1.0.0
	 * @var array $request_body Request body.
	 */
	private array $request_body = array();

	/**
	 * Method used to do API call.
	 *
	 * @since 1.0.0
	 * @var string $method API call method.
	 */
	private string $method = 'POST';

	/**
	 * Request timeout.
	 *
	 * @since 1.3.0
	 * @var int $timeout Timeout in seconds.
	 */
	private int $timeout = 10;

	/**
	 * Setter for $endpoint.
	 *
	 * @since 1.0.0
	 *
	 * @param string $endpoint Endpoint.
	 */
	protected function set_endpoint( string $endpoint ): void {
		$this->endpoint = $endpoint;
	}

	/**
	 * Setter for $body.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Array of data.
	 */
	protected function set_request_body( array $data ): void {
		$this->request_body = $data;
	}

	/**
	 * Setter for $method.
	 *
	 * @since 1.0.0
	 *
	 * @param string $method Method.
	 */
	protected function set_method( string $method ): void {
		$this->method = $method;
	}

	/**
	 * Setter for $timeout.
	 *
	 * @since 1.3.0
	 *
	 * @param int $timeout Timeout in seconds.
	 */
	protected function set_timeout( int $timeout ): void {
		$this->timeout = $timeout;
	}

	/**
	 * Get API URL.
	 *
	 * @since 1.1.0
	 *
	 * @return string
	 */
	private function get_url(): string {
		$url = $this->api_url;
		if ( defined( 'MY_OWN_CDN_API' ) && MY_OWN_CDN_API ) {
			$url = trailingslashit( MY_OWN_CDN_API );
		}

		return $url . $this->endpoint;
	}

	/**
	 * Get arguments for request.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	private function get_args(): array {
		$header = array(
			'Accept'       => 'application/json',
			'Content-Type' => 'application/json',
		);

		$args = array(
			'method'  => $this->method,
			'timeout' => $this->timeout,
			'headers' => array_merge( $header, $this->add_auth_headers() ),
		);

		if ( ! empty( $this->request_body ) && 'POST' === $args['method'] ) {
			$args['body'] = $this->request_body;
		}

		return $args;
	}

	/**
	 * Do API request.
	 *
	 * @since 1.0.0
	 *
	 * @param array $params Parameters to append to URL.
	 * @return array
	 * @throws Exception API exception.
	 */
	protected function request( array $params = array() ): array {
		$url  = $this->get_url();
		$args = $this->get_args();

		if ( ! empty( $params ) ) {
			$url = add_query_arg( $params, $url );
		}

		if ( 'GET' === $args['method'] ) {
			$response = wp_remote_get( $url, $args );
		} elseif ( 'POST' === $args['method'] ) {
			$response = wp_remote_post( $url, $args );
		} elseif ( 'DELETE' === $args['method'] ) {
			$response = wp_remote_request( $url, $args );
		} else {
			throw new Exception( esc_html__( 'Unsupported API call method', 'my-own-cdn' ) );
		}

		if ( is_wp_error( $response ) ) {
			throw new Exception( esc_html( $response->get_error_message() ) );
		}

		return $response;
	}

	/**
	 * Add authorization headers.
	 *
	 * @since 1.2.0 Moved from Content class.
	 *
	 * @return array|string[]
	 */
	public function add_auth_headers(): array {
		$token = User::get_token();

		if ( empty( $token ) ) {
			return array();
		}

		return array(
			'Authorization' => 'Bearer ' . $token,
		);
	}

	/**
	 * Improve error messages.
	 *
	 * Filters the error messages from the API and makes them more user-friendly.
	 *
	 * @since 1.0.0
	 *
	 * @param string $message Error message from API.
	 * @return string
	 */
	protected function filter_error_response( string $message ): string {
		// Invalid API key.
		if ( str_contains( $message, 'Unauthenticated' ) ) {
			$message = __( 'Expired or invalid API key.', 'my-own-cdn' );
		}

		return $message;
	}

	/**
	 * Process API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $response API response.
	 * @return stdClass
	 * @throws Exception Response exception.
	 */
	protected function process_response( array $response ): stdClass {
		$code = wp_remote_retrieve_response_code( $response );
		$body = wp_remote_retrieve_body( $response );
		$body = json_decode( $body );

		if ( 200 === $code || 201 === $code || 202 === $code ) {
			return $body;
		}

		if ( isset( $body->message ) ) {
			throw new Exception( esc_html( $this->filter_error_response( $body->message ) ) );
		}

		throw new Exception( esc_html__( 'Error doing API call. Please try again.', 'my-own-cdn' ) );
	}
}
