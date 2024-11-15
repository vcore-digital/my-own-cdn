<?php /* phpcs:ignore WordPress.Files.FileName.InvalidClassFileName */
/**
 * Admin functionality for the plugin
 *
 * @since 1.0.0
 * @package MyOwnCDN
 */

namespace MyOwnCDN;

use MyOwnCDN\Traits\HasUtils;
use MyOwnCDN\Traits\HasView;

/**
 * Admin class.
 */
class Admin {
	use HasView;
	use HasUtils;

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
}
