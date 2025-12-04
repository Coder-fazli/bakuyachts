<?php
/**
 * The Front Page template file.
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0.31
 */

get_header();

// If front-page is a static page
if ( get_option( 'show_on_front' ) == 'page' ) {

	// If Front Page Builder is enabled - display sections
	if ( yacht_rental_is_on( yacht_rental_get_theme_option( 'front_page_enabled', false ) ) ) {

		if ( have_posts() ) {
			the_post();
		}

		$yacht_rental_sections = yacht_rental_array_get_keys_by_value( yacht_rental_get_theme_option( 'front_page_sections' ) );
		if ( is_array( $yacht_rental_sections ) ) {
			foreach ( $yacht_rental_sections as $yacht_rental_section ) {
				get_template_part( apply_filters( 'yacht_rental_filter_get_template_part', 'front-page/section', $yacht_rental_section ), $yacht_rental_section );
			}
		}

		// Else if this page is a blog archive
	} elseif ( is_page_template( 'blog.php' ) ) {
		get_template_part( apply_filters( 'yacht_rental_filter_get_template_part', 'blog' ) );

		// Else - display a native page content
	} else {
		get_template_part( apply_filters( 'yacht_rental_filter_get_template_part', 'page' ) );
	}

	// Else get the template 'index.php' to show posts
} else {
	get_template_part( apply_filters( 'yacht_rental_filter_get_template_part', 'index' ) );
}

get_footer();
