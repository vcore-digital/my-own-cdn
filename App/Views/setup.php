<?php /* phpcs:ignore WordPress.Files.FileName.InvalidClassFileName */
/**
 * Setup view
 *
 * @since 1.0.0
 * @package MyOwnCDN
 */

namespace MyOwnCDN\Views;

use MyOwnCDN\Models\CDN;

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
	<h2><?php esc_html_e( 'Setup', 'my-own-cdn' ); ?></h2>

	<p>
		<?php esc_html_e( 'MyOwnCDN is a content delivery network that allows you to serve your website assets from a CDN provider of your choice.', 'my-own-cdn' ); ?>
	</p>

	<div class="notice notice-error" id="moc-ajax-notice">
		<p></p>
	</div>

	<hr>

	<form id="moc-provider-form">
		<table class="form-table" role="presentation">
			<tbody>
			<tr>
				<th scope="row">
					<label for="provider"><?php esc_html_e( 'CDN provider', 'my-own-cdn' ); ?></label>
				</th>
				<td>
					<select name="provider" id="provider">
						<option value="0" <?php selected( CDN::get_provider(), '' ); ?>>— <?php esc_html_e( 'Select', 'my-own-cdn' ); ?> —</option>
						<option class="level-0" value="bunny" <?php selected( CDN::get_provider(), 'bunny' ); ?>>Bunny.net</option>
						<option class="level-0" value="cachefly" <?php selected( CDN::get_provider(), 'cachefly' ); ?>>CacheFly</option>
						<option class="level-0" value="fastly" <?php selected( CDN::get_provider(), 'fastly' ); ?>>Fastly</option>
						<option class="level-0" value="gcore" <?php selected( CDN::get_provider(), 'gcore' ); ?>>Gcore</option>
					</select>
					<button type="submit" id="moc-provider-btn" class="button button-primary">
						<?php esc_html_e( 'Select Provider', 'my-own-cdn' ); ?>
					</button>
				</td>
			</tr>
			</tbody>
		</table>
	</form>

	<hr>

</div>

<div class="moc-footer">
	<p>
		<a href="#" id="moc-logout-btn">
			<?php esc_html_e( 'Disconnect', 'my-own-cdn' ); ?>
		</a>
	</p>
</div>

<div class="clear"></div>
