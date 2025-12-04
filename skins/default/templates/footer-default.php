<?php
/**
 * The template to display default site footer
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0.10
 */

?>
<footer class="footer_wrap footer_default
<?php
$yacht_rental_footer_scheme = yacht_rental_get_theme_option( 'footer_scheme' );
if ( ! empty( $yacht_rental_footer_scheme ) && ! yacht_rental_is_inherit( $yacht_rental_footer_scheme  ) ) {
	echo ' scheme_' . esc_attr( $yacht_rental_footer_scheme );
}
?>
				">
	<?php

	// Footer widgets area
	get_template_part( apply_filters( 'yacht_rental_filter_get_template_part', 'templates/footer-widgets' ) );

	// Logo
	get_template_part( apply_filters( 'yacht_rental_filter_get_template_part', 'templates/footer-logo' ) );

	// Socials
	get_template_part( apply_filters( 'yacht_rental_filter_get_template_part', 'templates/footer-socials' ) );

	// Copyright area
	get_template_part( apply_filters( 'yacht_rental_filter_get_template_part', 'templates/footer-copyright' ) );

	?>
</footer><!-- /.footer_wrap -->
