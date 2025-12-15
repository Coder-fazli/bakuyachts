<?php
/**
 * The template for displaying Packages Archive
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0
 */

get_header('custom');

// Get the main content
if ( have_posts() ) {
	the_posts_navigation();

	while ( have_posts() ) {
		the_post();
		get_template_part( 'content', get_post_type() );
	}

	the_posts_navigation();
} else {
	get_template_part( 'content', 'none' );
}

get_footer('custom');
?>
