<?php
/**
 * The template to display default site footer
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0.10
 */

$yacht_rental_footer_id = yacht_rental_get_custom_footer_id();
$yacht_rental_footer_meta = get_post_meta( $yacht_rental_footer_id, 'trx_addons_options', true );
if ( ! empty( $yacht_rental_footer_meta['margin'] ) ) {
	yacht_rental_add_inline_css( sprintf( '.page_content_wrap{padding-bottom:%s}', esc_attr( yacht_rental_prepare_css_value( $yacht_rental_footer_meta['margin'] ) ) ) );
}
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr( $yacht_rental_footer_id ); ?> footer_custom_<?php echo esc_attr( sanitize_title( get_the_title( $yacht_rental_footer_id ) ) ); ?>
						<?php
						$yacht_rental_footer_scheme = yacht_rental_get_theme_option( 'footer_scheme' );
						if ( ! empty( $yacht_rental_footer_scheme ) && ! yacht_rental_is_inherit( $yacht_rental_footer_scheme  ) ) {
							echo ' scheme_' . esc_attr( $yacht_rental_footer_scheme );
						}
						?>
						">
	<?php
	// Custom footer's layout
	do_action( 'yacht_rental_action_show_layout', $yacht_rental_footer_id );
	?>
</footer><!-- /.footer_wrap -->
