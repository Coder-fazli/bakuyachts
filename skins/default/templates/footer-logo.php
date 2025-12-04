<?php
/**
 * The template to display the site logo in the footer
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0.10
 */

// Logo
if ( yacht_rental_is_on( yacht_rental_get_theme_option( 'logo_in_footer' ) ) ) {
	$yacht_rental_logo_image = yacht_rental_get_logo_image( 'footer' );
	$yacht_rental_logo_text  = get_bloginfo( 'name' );
	if ( ! empty( $yacht_rental_logo_image['logo'] ) || ! empty( $yacht_rental_logo_text ) ) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if ( ! empty( $yacht_rental_logo_image['logo'] ) ) {
					$yacht_rental_attr = yacht_rental_getimagesize( $yacht_rental_logo_image['logo'] );
					echo '<a href="' . esc_url( home_url( '/' ) ) . '">'
							. '<img src="' . esc_url( $yacht_rental_logo_image['logo'] ) . '"'
								. ( ! empty( $yacht_rental_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $yacht_rental_logo_image['logo_retina'] ) . ' 2x"' : '' )
								. ' class="logo_footer_image"'
								. ' alt="' . esc_attr__( 'Site logo', 'yacht-rental' ) . '"'
								. ( ! empty( $yacht_rental_attr[3] ) ? ' ' . wp_kses_data( $yacht_rental_attr[3] ) : '' )
							. '>'
						. '</a>';
				} elseif ( ! empty( $yacht_rental_logo_text ) ) {
					echo '<h1 class="logo_footer_text">'
							. '<a href="' . esc_url( home_url( '/' ) ) . '">'
								. esc_html( $yacht_rental_logo_text )
							. '</a>'
						. '</h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
