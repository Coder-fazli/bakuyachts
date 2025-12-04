<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: //codex.wordpress.org/Template_Hierarchy
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0
 */

$yacht_rental_template = apply_filters( 'yacht_rental_filter_get_template_part', yacht_rental_blog_archive_get_template() );

if ( ! empty( $yacht_rental_template ) && 'index' != $yacht_rental_template ) {

	get_template_part( $yacht_rental_template );

} else {

	yacht_rental_storage_set( 'blog_archive', true );

	get_header();

	if ( have_posts() ) {

		// Query params
		$yacht_rental_stickies   = is_home()
								|| ( in_array( yacht_rental_get_theme_option( 'post_type' ), array( '', 'post' ) )
									&& (int) yacht_rental_get_theme_option( 'parent_cat' ) == 0
									)
										? get_option( 'sticky_posts' )
										: false;
		$yacht_rental_post_type  = yacht_rental_get_theme_option( 'post_type' );
		$yacht_rental_args       = array(
								'blog_style'     => yacht_rental_get_theme_option( 'blog_style' ),
								'post_type'      => $yacht_rental_post_type,
								'taxonomy'       => yacht_rental_get_post_type_taxonomy( $yacht_rental_post_type ),
								'parent_cat'     => yacht_rental_get_theme_option( 'parent_cat' ),
								'posts_per_page' => yacht_rental_get_theme_option( 'posts_per_page' ),
								'sticky'         => yacht_rental_get_theme_option( 'sticky_style', 'inherit' ) == 'columns'
															&& is_array( $yacht_rental_stickies )
															&& count( $yacht_rental_stickies ) > 0
															&& get_query_var( 'paged' ) < 1
								);

		yacht_rental_blog_archive_start();

		do_action( 'yacht_rental_action_blog_archive_start' );

		if ( is_author() ) {
			do_action( 'yacht_rental_action_before_page_author' );
			get_template_part( apply_filters( 'yacht_rental_filter_get_template_part', 'templates/author-page' ) );
			do_action( 'yacht_rental_action_after_page_author' );
		}

		if ( yacht_rental_get_theme_option( 'show_filters', 0 ) ) {
			do_action( 'yacht_rental_action_before_page_filters' );
			yacht_rental_show_filters( $yacht_rental_args );
			do_action( 'yacht_rental_action_after_page_filters' );
		} else {
			do_action( 'yacht_rental_action_before_page_posts' );
			yacht_rental_show_posts( array_merge( $yacht_rental_args, array( 'cat' => $yacht_rental_args['parent_cat'] ) ) );
			do_action( 'yacht_rental_action_after_page_posts' );
		}

		do_action( 'yacht_rental_action_blog_archive_end' );

		yacht_rental_blog_archive_end();

	} else {

		if ( is_search() ) {
			get_template_part( apply_filters( 'yacht_rental_filter_get_template_part', 'templates/content', 'none-search' ), 'none-search' );
		} else {
			get_template_part( apply_filters( 'yacht_rental_filter_get_template_part', 'templates/content', 'none-archive' ), 'none-archive' );
		}
	}

	get_footer();
}
