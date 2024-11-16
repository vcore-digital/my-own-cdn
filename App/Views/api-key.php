<?php /* phpcs:ignore WordPress.Files.FileName.InvalidClassFileName */
/**
 * API key view
 *
 * @since 1.0.0
 * @package MyOwnCDN
 */

namespace MyOwnCDN\Views;

if ( ! defined( 'WPINC' ) ) {
	die;
}

?>


<div class="moc-header">
	<div class="moc-title-section">
		<h1><?php esc_html_e( 'MyOwnCDN', 'my-own-cdn' ); ?></h1>
	</div>
</div>

<hr class="wp-header-end">

<div class="moc-settings-body">
	<h2><?php esc_html_e( 'API key', 'my-own-cdn' ); ?></h2>

	<p>
		<?php esc_html_e( 'MyOwnCDN is a content delivery network that allows you to serve your website assets from a CDN provider of your choice.', 'my-own-cdn' ); ?>
	</p>

	<p>
		<?php
		printf( /* translators: %1$s - opening <a> tag for API key, %2$s - closing </a> tag */
			esc_html__( "Don't have an API token? %1\$sGenerate%2\$s a key in your account.", 'my-own-cdn' ),
			'<a href="' . esc_url( $this->get_url( 'site-login' ) ) . '" target="_blank">',
			'</a>'
		);
		?>
	</p>

	<div class="notice notice-error" id="moc-ajax-notice">
		<p></p>
	</div>

	<hr>

	<form id="moc-api-key-form">
		<table class="form-table" role="presentation">
			<tbody>
			<tr>
				<th scope="row">
					<label for="api-key"><?php esc_html_e( 'API token', 'my-own-cdn' ); ?></label>
				</th>
				<td>
					<input type="text" id="api-key" name="api-key" placeholder="<?php esc_attr_e( 'API token', 'my-own-cdn' ); ?>" required>
					<button type="submit" id="moc-save-btn" class="button button-primary">
						<?php esc_html_e( 'Save', 'my-own-cdn' ); ?>
					</button>
				</td>
			</tr>
			</tbody>
		</table>
	</form>

	<a href="<?php echo esc_url( $this->get_url( 'register' ) ); ?>" target="_blank"><?php esc_html_e( 'Create an account', 'my-own-cdn' ); ?></a>
</div>

<div class="clear"></div>
