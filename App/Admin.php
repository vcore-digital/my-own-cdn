<?php /* phpcs:ignore WordPress.Files.FileName.InvalidClassFileName */
/**
 * Admin functionality for the plugin
 *
 * @since 1.0.0
 * @package MyOwnCDN
 */

namespace MyOwnCDN;

use Exception;
use MyOwnCDN\Api\API;
use MyOwnCDN\Models\User;
use MyOwnCDN\Traits\HasSettings;
use MyOwnCDN\Traits\HasUtils;
use MyOwnCDN\Traits\HasView;

/**
 * Admin class.
 */
class Admin {
	use HasSettings;
	use HasUtils;
	use HasView;

	/**
	 * API instance.
	 *
	 * @since 1.0.0
	 * @var API $api API instance.
	 */
	protected API $api;

	/**
	 * Class constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		if ( ! is_admin() ) {
			return;
		}

		add_action( 'admin_menu', array( $this, 'add_menu' ) );
		add_action( 'admin_init', array( $this, 'load_plugin_textdomain' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		add_filter( 'admin_body_class', array( $this, 'admin_body_class' ) );
		add_filter( 'plugin_action_links_my-own-cdn/my-own-cdn.php', array( $this, 'settings_link' ) );

		if ( wp_doing_ajax() ) {
			$this->api = new API();
			add_action( 'wp_ajax_moc_update_key', array( $this, 'update_key' ) );
			add_action( 'wp_ajax_moc_logout', array( $this, 'logout' ) );
			add_action( 'wp_ajax_moc_update_status', array( $this, 'update_status' ) );
		}
	}

	/**
	 * Add the admin menu.
	 *
	 * @since 1.0.0
	 */
	public function add_menu(): void {
		add_menu_page(
			'MyOwnCDN',
			'MyOwnCDN',
			'manage_options',
			$this->get_slug(),
			array( $this, 'render_page' ),
			'dashicons-admin-site',
			90
		);
	}

	/**
	 * Register localization for the plugin.
	 *
	 * @since 1.0.0
	 */
	public function load_plugin_textdomain(): void {
		load_plugin_textdomain(
			$this->get_slug(),
			false,
			plugin_basename( MY_OWN_CDN_PATH ) . '/languages'
		);
	}

	/**
	 * Load plugin styles and scripts.
	 *
	 * @since 1.0.0
	 *
	 * @param string $hook The current admin page.
	 */
	public function enqueue_assets( string $hook ): void {
		// Run only on plugin pages.
		if ( 'toplevel_page_my-own-cdn' !== $hook ) {
			return;
		}

		wp_enqueue_style(
			$this->get_slug(),
			MY_OWN_CDN_URL . 'assets/css/moc.min.css',
			array(),
			VERSION
		);

		wp_enqueue_script(
			$this->get_slug(),
			MY_OWN_CDN_URL . 'assets/js/moc.min.js',
			array(),
			VERSION,
			true
		);

		wp_localize_script(
			$this->get_slug(),
			'MOCJS',
			array(
				'i18n'  => array(
					'refreshStatus' => esc_html__( 'Refresh status', 'my-own-cdn' ),
					'updating'      => esc_html__( 'Updating...', 'my-own-cdn' ),
				),
				'links' => array(
					'pluginURL' => $this->get_url(),
				),
				'nonce' => wp_create_nonce( 'my-own-cdn' ),
			)
		);
	}

	/**
	 * Add plugin class to the body.
	 *
	 * @since 1.0.0
	 *
	 * @param string $classes Space-separated list of CSS classes.
	 *
	 * @return String
	 */
	public function admin_body_class( string $classes ): string {
		$page = filter_input( INPUT_GET, 'page', FILTER_UNSAFE_RAW );

		if ( $this->get_slug() === $page ) {
			$classes .= ' my-own-cdn ';
		}

		return $classes;
	}

	/**
	 * Add `Settings` link on the `Plugins` page.
	 *
	 * @since 1.0.0
	 *
	 * @param array $actions Actions array.
	 *
	 * @return array
	 */
	public function settings_link( array $actions ): array {
		return array_merge(
			array(
				'settings' => '<a href="' . $this->get_url() . '" aria-label="' . esc_attr( __( 'Settings', 'my-own-cdn' ) ) . '">' . esc_html__( 'Settings', 'my-own-cdn' ) . '</a>',
			),
			$actions
		);
	}

	/**
	 * Update API token.
	 *
	 * @since 1.0.0
	 */
	public function update_key(): void {
		$this->check_permissions();

		$token = filter_input( INPUT_POST, 'token', FILTER_UNSAFE_RAW );
		$token = sanitize_text_field( $token );
		User::set_token( $token );

		try {
			$response = $this->api->status();

			if ( ! empty( $response->provider ) ) {
				$this->set_setting( 'provider', $response->provider );
			}

			if ( ! empty( $response->status ) ) {
				$this->set_setting( 'status', $response->status );
			}

			wp_send_json_success( $response );
		} catch ( Exception $e ) {
			User::delete_token();
			wp_send_json_error( $e->getMessage() );
		}
	}

	/**
	 * Update status.
	 *
	 * @since 1.0.0
	 */
	public function update_status(): void {
		$this->check_permissions();

		try {
			$response = $this->api->status();

			if ( ! empty( $response->provider ) ) {
				$this->set_setting( 'provider', $response->provider );
			}

			if ( ! empty( $response->status ) ) {
				$this->set_setting( 'status', $response->status );
			}

			wp_send_json_success( $response );
		} catch ( Exception $e ) {
			wp_send_json_error( $e->getMessage() );
		}
	}

	/**
	 * Logout.
	 *
	 * @since 1.0.0
	 */
	public function logout(): void {
		$this->check_permissions();

		delete_option( 'moc-api-token' );

		wp_send_json_success();
	}

	/**
	 * Check request permissions.
	 *
	 * @since 1.0.0
	 *
	 * @param string $type Capability to check.
	 *
	 * @return void
	 */
	private function check_permissions( string $type = 'manage_options' ) {
		check_ajax_referer( 'my-own-cdn' );

		if ( ! current_user_can( $type ) ) {
			wp_send_json_error( esc_html__( 'Insufficient permissions', 'my-own-cdn' ) );
		}
	}
}
