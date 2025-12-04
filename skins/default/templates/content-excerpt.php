<?php
/**
 * The default template to display the content
 *
 * Used for index/archive/search.
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0
 */

$yacht_rental_template_args = get_query_var( 'yacht_rental_template_args' );
$yacht_rental_columns = 1;
if ( is_array( $yacht_rental_template_args ) ) {
	$yacht_rental_columns    = empty( $yacht_rental_template_args['columns'] ) ? 1 : max( 1, $yacht_rental_template_args['columns'] );
	$yacht_rental_blog_style = array( $yacht_rental_template_args['type'], $yacht_rental_columns );
	if ( ! empty( $yacht_rental_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $yacht_rental_columns > 1 ) {
	    $yacht_rental_columns_class = yacht_rental_get_column_class( 1, $yacht_rental_columns, ! empty( $yacht_rental_template_args['columns_tablet']) ? $yacht_rental_template_args['columns_tablet'] : '', ! empty($yacht_rental_template_args['columns_mobile']) ? $yacht_rental_template_args['columns_mobile'] : '' );
		?>
		<div class="<?php echo esc_attr( $yacht_rental_columns_class ); ?>">
		<?php
	}
} else {
	$yacht_rental_template_args = array();
}
$yacht_rental_expanded    = ! yacht_rental_sidebar_present() && yacht_rental_get_theme_option( 'expand_content' ) == 'expand';
$yacht_rental_post_format = get_post_format();
$yacht_rental_post_format = empty( $yacht_rental_post_format ) ? 'standard' : str_replace( 'post-format-', '', $yacht_rental_post_format );
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_item_container post_layout_excerpt post_format_' . esc_attr( $yacht_rental_post_format ) );
	yacht_rental_add_blog_animation( $yacht_rental_template_args );
	?>
>
	<?php

	// Sticky label
	if ( is_sticky() && ! is_paged() ) {
		?>
		<span class="post_label label_sticky"></span>
		<?php
	}

	// Featured image
	$yacht_rental_hover      = ! empty( $yacht_rental_template_args['hover'] ) && ! yacht_rental_is_inherit( $yacht_rental_template_args['hover'] )
							? $yacht_rental_template_args['hover']
							: yacht_rental_get_theme_option( 'image_hover' );
	$yacht_rental_components = ! empty( $yacht_rental_template_args['meta_parts'] )
							? ( is_array( $yacht_rental_template_args['meta_parts'] )
								? $yacht_rental_template_args['meta_parts']
								: array_map( 'trim', explode( ',', $yacht_rental_template_args['meta_parts'] ) )
								)
							: yacht_rental_array_get_keys_by_value( yacht_rental_get_theme_option( 'meta_parts' ) );
	yacht_rental_show_post_featured( apply_filters( 'yacht_rental_filter_args_featured',
		array(
			'no_links'   => ! empty( $yacht_rental_template_args['no_links'] ),
			'hover'      => $yacht_rental_hover,
			'meta_parts' => $yacht_rental_components,
			'thumb_size' => ! empty( $yacht_rental_template_args['thumb_size'] )
							? $yacht_rental_template_args['thumb_size']
							: yacht_rental_get_thumb_size( strpos( yacht_rental_get_theme_option( 'body_style' ), 'full' ) !== false
								? 'full'
								: ( $yacht_rental_expanded 
									? 'huge' 
									: 'big' 
									)
								),
		),
		'content-excerpt',
		$yacht_rental_template_args
	) );

	// Title and post meta
	$yacht_rental_show_title = get_the_title() != '';
	$yacht_rental_show_meta  = count( $yacht_rental_components ) > 0 && ! in_array( $yacht_rental_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );

	if ( $yacht_rental_show_title ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			if ( apply_filters( 'yacht_rental_filter_show_blog_title', true, 'excerpt' ) ) {
				do_action( 'yacht_rental_action_before_post_title' );
				if ( empty( $yacht_rental_template_args['no_links'] ) ) {
					the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
				} else {
					the_title( '<h3 class="post_title entry-title">', '</h3>' );
				}
				do_action( 'yacht_rental_action_after_post_title' );
			}
			?>
		</div><!-- .post_header -->
		<?php
	}

	// Post content
	if ( apply_filters( 'yacht_rental_filter_show_blog_excerpt', empty( $yacht_rental_template_args['hide_excerpt'] ) && yacht_rental_get_theme_option( 'excerpt_length' ) > 0, 'excerpt' ) ) {
		?>
		<div class="post_content entry-content">
			<?php

			// Post meta
			if ( apply_filters( 'yacht_rental_filter_show_blog_meta', $yacht_rental_show_meta, $yacht_rental_components, 'excerpt' ) ) {
				if ( count( $yacht_rental_components ) > 0 ) {
					do_action( 'yacht_rental_action_before_post_meta' );
					yacht_rental_show_post_meta(
						apply_filters(
							'yacht_rental_filter_post_meta_args', array(
								'components' => join( ',', $yacht_rental_components ),
								'seo'        => false,
								'echo'       => true,
							), 'excerpt', 1
						)
					);
					do_action( 'yacht_rental_action_after_post_meta' );
				}
			}

			if ( yacht_rental_get_theme_option( 'blog_content' ) == 'fullpost' ) {
				// Post content area
				?>
				<div class="post_content_inner">
					<?php
					do_action( 'yacht_rental_action_before_full_post_content' );
					the_content( '' );
					do_action( 'yacht_rental_action_after_full_post_content' );
					?>
				</div>
				<?php
				// Inner pages
				wp_link_pages(
					array(
						'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'yacht-rental' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
						'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'yacht-rental' ) . ' </span>%',
						'separator'   => '<span class="screen-reader-text">, </span>',
					)
				);
			} else {
				// Post content area
				yacht_rental_show_post_content( $yacht_rental_template_args, '<div class="post_content_inner">', '</div>' );
			}

			// More button
			if ( apply_filters( 'yacht_rental_filter_show_blog_readmore',  ! isset( $yacht_rental_template_args['more_button'] ) || ! empty( $yacht_rental_template_args['more_button'] ), 'excerpt' ) ) {
				if ( empty( $yacht_rental_template_args['no_links'] ) ) {
					do_action( 'yacht_rental_action_before_post_readmore' );
					if ( yacht_rental_get_theme_option( 'blog_content' ) != 'fullpost' ) {
						yacht_rental_show_post_more_link( $yacht_rental_template_args, '<p>', '</p>' );
					} else {
						yacht_rental_show_post_comments_link( $yacht_rental_template_args, '<p>', '</p>' );
					}
					do_action( 'yacht_rental_action_after_post_readmore' );
				}
			}

			?>
		</div><!-- .entry-content -->
		<?php
	}
	?>
</article>
<?php

if ( is_array( $yacht_rental_template_args ) ) {
	if ( ! empty( $yacht_rental_template_args['slider'] ) || $yacht_rental_columns > 1 ) {
		?>
		</div>
		<?php
	}
}
