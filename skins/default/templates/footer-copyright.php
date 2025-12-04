<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0.10
 */

// Copyright area
?> 
<div class="footer_copyright_wrap
<?php
$yacht_rental_copyright_scheme = yacht_rental_get_theme_option( 'copyright_scheme' );
if ( ! empty( $yacht_rental_copyright_scheme ) && ! yacht_rental_is_inherit( $yacht_rental_copyright_scheme  ) ) {
	echo ' scheme_' . esc_attr( $yacht_rental_copyright_scheme );
}
?>
				">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text">
			<?php
				$yacht_rental_copyright = yacht_rental_get_theme_option( 'copyright' );
			if ( ! empty( $yacht_rental_copyright ) ) {
				// Replace {{Y}} or {Y} with the current year
				$yacht_rental_copyright = str_replace( array( '{{Y}}', '{Y}' ), date( 'Y' ), $yacht_rental_copyright );
				// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
				$yacht_rental_copyright = yacht_rental_prepare_macros( $yacht_rental_copyright );
				// Display copyright
				echo wp_kses( nl2br( $yacht_rental_copyright ), 'yacht_rental_kses_content' );
			}
			?>
			</div>
		</div>
	</div>
</div>
