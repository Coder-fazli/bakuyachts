<?php
/**
 * The template to display single post
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0
 */

// Full post loading
$full_post_loading          = yacht_rental_get_value_gp( 'action' ) == 'full_post_loading';

// Prev post loading
$prev_post_loading          = yacht_rental_get_value_gp( 'action' ) == 'prev_post_loading';
$prev_post_loading_type     = yacht_rental_get_theme_option( 'posts_navigation_scroll_which_block', 'article' );

// Position of the related posts
$yacht_rental_related_position   = yacht_rental_get_theme_option( 'related_position', 'below_content' );

// Type of the prev/next post navigation
$yacht_rental_posts_navigation   = yacht_rental_get_theme_option( 'posts_navigation' );
$yacht_rental_prev_post          = false;
$yacht_rental_prev_post_same_cat = (int)yacht_rental_get_theme_option( 'posts_navigation_scroll_same_cat', 1 );

// Rewrite style of the single post if current post loading via AJAX and featured image and title is not in the content
if ( ( $full_post_loading 
		|| 
		( $prev_post_loading && 'article' == $prev_post_loading_type )
	) 
	&& 
	! in_array( yacht_rental_get_theme_option( 'single_style' ), array( 'style-6' ) )
) {
	yacht_rental_storage_set_array( 'options_meta', 'single_style', 'style-6' );
}

do_action( 'yacht_rental_action_prev_post_loading', $prev_post_loading, $prev_post_loading_type );

get_header();

while ( have_posts() ) {

	the_post();

	// Type of the prev/next post navigation
	if ( 'scroll' == $yacht_rental_posts_navigation ) {
		$yacht_rental_prev_post = get_previous_post( $yacht_rental_prev_post_same_cat );  // Get post from same category
		if ( ! $yacht_rental_prev_post && $yacht_rental_prev_post_same_cat ) {
			$yacht_rental_prev_post = get_previous_post( false );                    // Get post from any category
		}
		if ( ! $yacht_rental_prev_post ) {
			$yacht_rental_posts_navigation = 'links';
		}
	}

	// Override some theme options to display featured image, title and post meta in the dynamic loaded posts
	if ( $full_post_loading || ( $prev_post_loading && $yacht_rental_prev_post ) ) {
		yacht_rental_sc_layouts_showed( 'featured', false );
		yacht_rental_sc_layouts_showed( 'title', false );
		yacht_rental_sc_layouts_showed( 'postmeta', false );
	}

	// If related posts should be inside the content
	if ( strpos( $yacht_rental_related_position, 'inside' ) === 0 ) {
		ob_start();
	}

	// Display post's content
	get_template_part( apply_filters( 'yacht_rental_filter_get_template_part', 'templates/content', 'single-' . yacht_rental_get_theme_option( 'single_style' ) ), 'single-' . yacht_rental_get_theme_option( 'single_style' ) );

	// If related posts should be inside the content
	if ( strpos( $yacht_rental_related_position, 'inside' ) === 0 ) {
		$yacht_rental_content = ob_get_contents();
		ob_end_clean();

		ob_start();
		do_action( 'yacht_rental_action_related_posts' );
		$yacht_rental_related_content = ob_get_contents();
		ob_end_clean();

		if ( ! empty( $yacht_rental_related_content ) ) {
			$yacht_rental_related_position_inside = max( 0, min( 9, yacht_rental_get_theme_option( 'related_position_inside' ) ) );
			if ( 0 == $yacht_rental_related_position_inside ) {
				$yacht_rental_related_position_inside = mt_rand( 1, 9 );
			}

			$yacht_rental_p_number         = 0;
			$yacht_rental_related_inserted = false;
			$yacht_rental_in_block         = false;
			$yacht_rental_content_start    = strpos( $yacht_rental_content, '<div class="post_content' );
			$yacht_rental_content_end      = strrpos( $yacht_rental_content, '</div>' );

			for ( $i = max( 0, $yacht_rental_content_start ); $i < min( strlen( $yacht_rental_content ) - 3, $yacht_rental_content_end ); $i++ ) {
				if ( $yacht_rental_content[ $i ] != '<' ) {
					continue;
				}
				if ( $yacht_rental_in_block ) {
					if ( strtolower( substr( $yacht_rental_content, $i + 1, 12 ) ) == '/blockquote>' ) {
						$yacht_rental_in_block = false;
						$i += 12;
					}
					continue;
				} else if ( strtolower( substr( $yacht_rental_content, $i + 1, 10 ) ) == 'blockquote' && in_array( $yacht_rental_content[ $i + 11 ], array( '>', ' ' ) ) ) {
					$yacht_rental_in_block = true;
					$i += 11;
					continue;
				} else if ( 'p' == $yacht_rental_content[ $i + 1 ] && in_array( $yacht_rental_content[ $i + 2 ], array( '>', ' ' ) ) ) {
					$yacht_rental_p_number++;
					if ( $yacht_rental_related_position_inside == $yacht_rental_p_number ) {
						$yacht_rental_related_inserted = true;
						$yacht_rental_content = ( $i > 0 ? substr( $yacht_rental_content, 0, $i ) : '' )
											. $yacht_rental_related_content
											. substr( $yacht_rental_content, $i );
					}
				}
			}
			if ( ! $yacht_rental_related_inserted ) {
				if ( $yacht_rental_content_end > 0 ) {
					$yacht_rental_content = substr( $yacht_rental_content, 0, $yacht_rental_content_end ) . $yacht_rental_related_content . substr( $yacht_rental_content, $yacht_rental_content_end );
				} else {
					$yacht_rental_content .= $yacht_rental_related_content;
				}
			}
		}

		yacht_rental_show_layout( $yacht_rental_content );
	}

	// Comments
	do_action( 'yacht_rental_action_before_comments' );
	comments_template();
	do_action( 'yacht_rental_action_after_comments' );

	// Related posts
	if ( 'below_content' == $yacht_rental_related_position
		&& ( 'scroll' != $yacht_rental_posts_navigation || (int)yacht_rental_get_theme_option( 'posts_navigation_scroll_hide_related', 0 ) == 0 )
		&& ( ! $full_post_loading || (int)yacht_rental_get_theme_option( 'open_full_post_hide_related', 1 ) == 0 )
	) {
		do_action( 'yacht_rental_action_related_posts' );
	}

	// Post navigation: type 'scroll'
	if ( 'scroll' == $yacht_rental_posts_navigation && ! $full_post_loading ) {
		?>
		<div class="nav-links-single-scroll"
			data-post-id="<?php echo esc_attr( get_the_ID( $yacht_rental_prev_post ) ); ?>"
			data-post-link="<?php echo esc_attr( get_permalink( $yacht_rental_prev_post ) ); ?>"
			data-post-title="<?php the_title_attribute( array( 'post' => $yacht_rental_prev_post ) ); ?>"
			data-cur-post-link="<?php echo esc_attr( get_permalink() ); ?>"
			data-cur-post-title="<?php the_title_attribute(); ?>"
			<?php do_action( 'yacht_rental_action_nav_links_single_scroll_data', $yacht_rental_prev_post ); ?>
		></div>
		<?php
	}
}

get_footer();
