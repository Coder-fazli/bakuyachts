<?php
/**
 * The template to display the socials in the footer
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0.10
 */


// Socials
if ( yacht_rental_is_on( yacht_rental_get_theme_option( 'socials_in_footer' ) ) ) {
	$yacht_rental_output = yacht_rental_get_socials_links();
	if ( '' != $yacht_rental_output ) {
		?>
		<div class="footer_socials_wrap socials_wrap">
			<div class="footer_socials_inner">
				<?php yacht_rental_show_layout( $yacht_rental_output ); ?>
			</div>
		</div>
		<?php
	}
}
