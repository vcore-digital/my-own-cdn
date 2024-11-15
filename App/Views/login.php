<?php /* phpcs:ignore WordPress.Files.FileName.InvalidClassFileName */
/**
 * Login view
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
	<h2><?php esc_html_e( 'Sign in', 'my-own-cdn' ); ?></h2>

	<p>
		<?php esc_html_e( 'MyOwnCDN is a content delivery network that allows you to serve your website assets from a CDN provider of your choice.', 'my-own-cdn' ); ?>
	</p>

	<p>
		<a href="<?php echo esc_url( $this->get_url( 'register' ) ); ?>" target="_blank"><?php esc_html_e( "Don't have an account?", 'my-own-cdn' ); ?></a>
		<?php esc_html_e( 'Already have an API key?', 'my-own-cdn' ); ?>
		<a href="<?php echo esc_url( $this->get_url( 'api-key' ) ); ?>"><?php esc_html_e( 'Add it here', 'my-own-cdn' ); ?></a>.
	</p>

	<hr>

	<table class="form-table" id="moc-login-form" role="presentation">
		<tbody>
			<tr>
				<th scope="row">
					<label for="email"><?php esc_html_e( 'Email address', 'my-own-cdn' ); ?></label>
				</th>
				<td>
					<input type="email" id="email" name="email" placeholder="<?php esc_attr_e( 'Email address', 'my-own-cdn' ); ?>" required>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="password"><?php esc_html_e( 'Password', 'my-own-cdn' ); ?></label>
				</th>
				<td>
					<input type="password" id="password" name="password" placeholder="<?php esc_attr_e( 'Password', 'my-own-cdn' ); ?>" required>
					<button type="submit" id="moc-login-btn" class="button button-primary">
						<?php esc_html_e( 'Login', 'my-own-cdn' ); ?>
					</button>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<div class="clear"></div>
