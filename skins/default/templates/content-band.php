<?php
/**
 * 'Band' template to display the content
 *
 * Used for index/archive/search.
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.71.0
 */

$yacht_rental_template_args = get_query_var( 'yacht_rental_template_args' );
if ( ! is_array( $yacht_rental_template_args ) ) {
	$yacht_rental_template_args = array(
								'type'    => 'band',
								'columns' => 1
								);
}

$yacht_rental_columns       = 1;

$yacht_rental_expanded      = ! yacht_rental_sidebar_present() && yacht_rental_get_theme_option( 'expand_content' ) == 'expand';

$yacht_rental_post_format   = get_post_format();
$yacht_rental_post_format   = empty( $yacht_rental_post_format ) ? 'standard' : str_replace( 'post-format-', '', $yacht_rental_post_format );

if ( is_array( $yacht_rental_template_args ) ) {
	$yacht_rental_columns    = empty( $yacht_rental_template_args['columns'] ) ? 1 : max( 1, $yacht_rental_template_args['columns'] );
	$yacht_rental_blog_style = array( $yacht_rental_template_args['type'], $yacht_rental_columns );
	if ( ! empty( $yacht_rental_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $yacht_rental_columns > 1 ) {
	    $yacht_rental_columns_class = yacht_rental_get_column_class( 1, $yacht_rental_columns, ! empty( $yacht_rental_template_args['columns_tablet']) ? $yacht_rental_template_args['columns_tablet'] : '', ! empty($yacht_rental_template_args['columns_mobile']) ? $yacht_rental_template_args['columns_mobile'] : '' );
				?><div class="<?php echo esc_attr( $yacht_rental_columns_class ); ?>"><?php
	}
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_item_container post_layout_band post_format_' . esc_attr( $yacht_rental_post_format ) );
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
			'thumb_bg'   => true,
			'thumb_ratio'   => '1:1',
			'thumb_size' => ! empty( $yacht_rental_template_args['thumb_size'] )
								? $yacht_rental_template_args['thumb_size']
								: yacht_rental_get_thumb_size( 
								in_array( $yacht_rental_post_format, array( 'gallery', 'audio', 'video' ) )
									? ( strpos( yacht_rental_get_theme_option( 'body_style' ), 'full' ) !== false
										? 'full'
										: ( $yacht_rental_expanded 
											? 'big' 
											: 'medium-square'
											)
										)
									: 'masonry-big'
								)
		),
		'content-band',
		$yacht_rental_template_args
	) );

	?><div class="post_content_wrap"><?php

		// Title and post meta
		$yacht_rental_show_title = get_the_title() != '';
		$yacht_rental_show_meta  = count( $yacht_rental_components ) > 0 && ! in_array( $yacht_rental_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );
		if ( $yacht_rental_show_title ) {
			?>
			<div class="post_header entry-header">
				<?php
				// Categories
				if ( apply_filters( 'yacht_rental_filter_show_blog_categories', $yacht_rental_show_meta && in_array( 'categories', $yacht_rental_components ), array( 'categories' ), 'band' ) ) {
					do_action( 'yacht_rental_action_before_post_category' );
					?>
					<div class="post_category">
						<?php
						yacht_rental_show_post_meta( apply_filters(
															'yacht_rental_filter_post_meta_args',
															array(
																'components' => 'categories',
																'seo'        => false,
																'echo'       => true,
																'cat_sep'    => false,
																),
															'hover_' . $yacht_rental_hover, 1
															)
											);
						?>
					</div>
					<?php
					$yacht_rental_components = yacht_rental_array_delete_by_value( $yacht_rental_components, 'categories' );
					do_action( 'yacht_rental_action_after_post_category' );
				}
				// Post title
				if ( apply_filters( 'yacht_rental_filter_show_blog_title', true, 'band' ) ) {
					do_action( 'yacht_rental_action_before_post_title' );
					if ( empty( $yacht_rental_template_args['no_links'] ) ) {
						the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
					} else {
						the_title( '<h4 class="post_title entry-title">', '</h4>' );
					}
					do_action( 'yacht_rental_action_after_post_title' );
				}
				?>
			</div><!-- .post_header -->
			<?php
		}

		// Post content
		if ( ! isset( $yacht_rental_template_args['excerpt_length'] ) && ! in_array( $yacht_rental_post_format, array( 'gallery', 'audio', 'video' ) ) ) {
			$yacht_rental_template_args['excerpt_length'] = 13;
		}
		if ( apply_filters( 'yacht_rental_filter_show_blog_excerpt', empty( $yacht_rental_template_args['hide_excerpt'] ) && yacht_rental_get_theme_option( 'excerpt_length' ) > 0, 'band' ) ) {
			?>
			<div class="post_content entry-content">
				<?php
				// Post content area
				yacht_rental_show_post_content( $yacht_rental_template_args, '<div class="post_content_inner">', '</div>' );
				?>
			</div><!-- .entry-content -->
			<?php
		}
		// Post meta
		if ( apply_filters( 'yacht_rental_filter_show_blog_meta', $yacht_rental_show_meta, $yacht_rental_components, 'band' ) ) {
			if ( count( $yacht_rental_components ) > 0 ) {
				do_action( 'yacht_rental_action_before_post_meta' );
				yacht_rental_show_post_meta(
					apply_filters(
						'yacht_rental_filter_post_meta_args', array(
							'components' => join( ',', $yacht_rental_components ),
							'seo'        => false,
							'echo'       => true,
						), 'band', 1
					)
				);
				do_action( 'yacht_rental_action_after_post_meta' );
			}
		}
		// More button
		if ( apply_filters( 'yacht_rental_filter_show_blog_readmore', ! $yacht_rental_show_title || ! empty( $yacht_rental_template_args['more_button'] ), 'band' ) ) {
			if ( empty( $yacht_rental_template_args['no_links'] ) ) {
				do_action( 'yacht_rental_action_before_post_readmore' );
				yacht_rental_show_post_more_link( $yacht_rental_template_args, '<div class="more-wrap">', '</div>' );
				do_action( 'yacht_rental_action_after_post_readmore' );
			}
		}
		?>
	</div>
</article>
<?php

if ( is_array( $yacht_rental_template_args ) ) {
	if ( ! empty( $yacht_rental_template_args['slider'] ) || $yacht_rental_columns > 1 ) {
		?>
		</div>
		<?php
	}
}
