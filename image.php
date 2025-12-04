<?php
/**
 * The template to display the attachment
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0
 */


get_header();

while ( have_posts() ) {
	the_post();

	// Display post's content
	get_template_part( apply_filters( 'yacht_rental_filter_get_template_part', 'templates/content', 'single-' . yacht_rental_get_theme_option( 'single_style' ) ), 'single-' . yacht_rental_get_theme_option( 'single_style' ) );

	// Parent post navigation.
	$yacht_rental_posts_navigation = yacht_rental_get_theme_option( 'posts_navigation' );
	if ( 'links' == $yacht_rental_posts_navigation ) {
		?>
		<div class="nav-links-single<?php
			if ( ! yacht_rental_is_off( yacht_rental_get_theme_option( 'posts_navigation_fixed', 0 ) ) ) {
				echo ' nav-links-fixed fixed';
			}
		?>">
			<?php
			the_post_navigation( apply_filters( 'yacht_rental_filter_post_navigation_args', array(
					'prev_text' => '<span class="nav-arrow"></span>'
						. '<span class="meta-nav" aria-hidden="true">' . esc_html__( 'Published in', 'yacht-rental' ) . '</span> '
						. '<span class="screen-reader-text">' . esc_html__( 'Previous post:', 'yacht-rental' ) . '</span> '
						. '<h5 class="post-title">%title</h5>'
						. '<span class="post_date">%date</span>',
			), 'image' ) );
			?>
		</div>
		<?php
	}

	// Comments
	do_action( 'yacht_rental_action_before_comments' );
	comments_template();
	do_action( 'yacht_rental_action_after_comments' );
}

get_footer();
