<?php
/**
 * The template to display default site header
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0
 */

$yacht_rental_header_css   = '';
$yacht_rental_header_image = get_header_image();
$yacht_rental_header_video = yacht_rental_get_header_video();
if ( ! empty( $yacht_rental_header_image ) && yacht_rental_trx_addons_featured_image_override( is_singular() || yacht_rental_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$yacht_rental_header_image = yacht_rental_get_current_mode_image( $yacht_rental_header_image );
}

?><header class="top_panel top_panel_default
	<?php
	echo ! empty( $yacht_rental_header_image ) || ! empty( $yacht_rental_header_video ) ? ' with_bg_image' : ' without_bg_image';
	if ( '' != $yacht_rental_header_video ) {
		echo ' with_bg_video';
	}
	if ( '' != $yacht_rental_header_image ) {
		echo ' ' . esc_attr( yacht_rental_add_inline_css_class( 'background-image: url(' . esc_url( $yacht_rental_header_image ) . ');' ) );
	}
	if ( is_single() && has_post_thumbnail() ) {
		echo ' with_featured_image';
	}
	if ( yacht_rental_is_on( yacht_rental_get_theme_option( 'header_fullheight' ) ) ) {
		echo ' header_fullheight yacht-rental-full-height';
	}
	$yacht_rental_header_scheme = yacht_rental_get_theme_option( 'header_scheme' );
	if ( ! empty( $yacht_rental_header_scheme ) && ! yacht_rental_is_inherit( $yacht_rental_header_scheme  ) ) {
		echo ' scheme_' . esc_attr( $yacht_rental_header_scheme );
	}
	?>
">
	<?php

	// Background video
	if ( ! empty( $yacht_rental_header_video ) ) {
		get_template_part( apply_filters( 'yacht_rental_filter_get_template_part', 'templates/header-video' ) );
	}

	// Main menu
	get_template_part( apply_filters( 'yacht_rental_filter_get_template_part', 'templates/header-navi' ) );

	// Mobile header
	if ( yacht_rental_is_on( yacht_rental_get_theme_option( 'header_mobile_enabled' ) ) ) {
		get_template_part( apply_filters( 'yacht_rental_filter_get_template_part', 'templates/header-mobile' ) );
	}

	// Page title and breadcrumbs area
	if ( ! is_single() ) {
		get_template_part( apply_filters( 'yacht_rental_filter_get_template_part', 'templates/header-title' ) );
	}

	// Header widgets area
	get_template_part( apply_filters( 'yacht_rental_filter_get_template_part', 'templates/header-widgets' ) );
	?>
</header>
