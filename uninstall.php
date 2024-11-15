<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @since 1.0.0
 * @package MyOwnCDN
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( 'moc-api-token' );
