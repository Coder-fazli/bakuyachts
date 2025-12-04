<?php
/**
 * The Classic template to display the content
 *
 * Used for index/archive/search.
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0
 */

$yacht_rental_template_args = get_query_var( 'yacht_rental_template_args' );

if ( is_array( $yacht_rental_template_args ) ) {
	$yacht_rental_columns    = empty( $yacht_rental_template_args['columns'] ) ? 2 : max( 1, $yacht_rental_template_args['columns'] );
	$yacht_rental_blog_style = array( $yacht_rental_template_args['type'], $yacht_rental_columns );
    $yacht_rental_columns_class = yacht_rental_get_column_class( 1, $yacht_rental_columns, ! empty( $yacht_rental_template_args['columns_tablet']) ? $yacht_rental_template_args['columns_tablet'] : '', ! empty($yacht_rental_template_args['columns_mobile']) ? $yacht_rental_template_args['columns_mobile'] : '' );
} else {
	$yacht_rental_template_args = array();
	$yacht_rental_blog_style = explode( '_', yacht_rental_get_theme_option( 'blog_style' ) );
	$yacht_rental_columns    = empty( $yacht_rental_blog_style[1] ) ? 2 : max( 1, $yacht_rental_blog_style[1] );
    $yacht_rental_columns_class = yacht_rental_get_column_class( 1, $yacht_rental_columns );
}
$yacht_rental_expanded   = ! yacht_rental_sidebar_present() && yacht_rental_get_theme_option( 'expand_content' ) == 'expand';

$yacht_rental_post_format = get_post_format();
$yacht_rental_post_format = empty( $yacht_rental_post_format ) ? 'standard' : str_replace( 'post-format-', '', $yacht_rental_post_format );

?><div class="<?php
	if ( ! empty( $yacht_rental_template_args['slider'] ) ) {
		echo ' slider-slide swiper-slide';
	} else {
		echo ( yacht_rental_is_blog_style_use_masonry( $yacht_rental_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $yacht_rental_columns ) : esc_attr( $yacht_rental_columns_class ) );
	}
?>"><article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $yacht_rental_post_format )
				. ' post_layout_classic post_layout_classic_' . esc_attr( $yacht_rental_columns )
				. ' post_layout_' . esc_attr( $yacht_rental_blog_style[0] )
				. ' post_layout_' . esc_attr( $yacht_rental_blog_style[0] ) . '_' . esc_attr( $yacht_rental_columns )
	);
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
								: explode( ',', $yacht_rental_template_args['meta_parts'] )
								)
							: yacht_rental_array_get_keys_by_value( yacht_rental_get_theme_option( 'meta_parts' ) );

	yacht_rental_show_post_featured( apply_filters( 'yacht_rental_filter_args_featured',
		array(
			'thumb_size' => ! empty( $yacht_rental_template_args['thumb_size'] )
				? $yacht_rental_template_args['thumb_size']
				: yacht_rental_get_thumb_size(
					'classic' == $yacht_rental_blog_style[0]
						? ( strpos( yacht_rental_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $yacht_rental_columns > 2 ? 'big' : 'huge' )
								: ( $yacht_rental_columns > 2
									? ( $yacht_rental_expanded ? 'square' : 'square' )
									: ($yacht_rental_columns > 1 ? 'square' : ( $yacht_rental_expanded ? 'huge' : 'big' ))
									)
							)
						: ( strpos( yacht_rental_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $yacht_rental_columns > 2 ? 'masonry-big' : 'full' )
								: ($yacht_rental_columns === 1 ? ( $yacht_rental_expanded ? 'huge' : 'big' ) : ( $yacht_rental_columns <= 2 && $yacht_rental_expanded ? 'masonry-big' : 'masonry' ))
							)
			),
			'hover'      => $yacht_rental_hover,
			'meta_parts' => $yacht_rental_components,
			'no_links'   => ! empty( $yacht_rental_template_args['no_links'] ),
        ),
        'content-classic',
        $yacht_rental_template_args
    ) );

	// Title and post meta
	$yacht_rental_show_title = get_the_title() != '';
	$yacht_rental_show_meta  = count( $yacht_rental_components ) > 0 && ! in_array( $yacht_rental_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );

	if ( $yacht_rental_show_title ) {
		?>
		<div class="post_header entry-header">
			<?php

			// Post meta
			if ( apply_filters( 'yacht_rental_filter_show_blog_meta', $yacht_rental_show_meta, $yacht_rental_components, 'classic' ) ) {
				if ( count( $yacht_rental_components ) > 0 ) {
					do_action( 'yacht_rental_action_before_post_meta' );
					yacht_rental_show_post_meta(
						apply_filters(
							'yacht_rental_filter_post_meta_args', array(
							'components' => join( ',', $yacht_rental_components ),
							'seo'        => false,
							'echo'       => true,
						), $yacht_rental_blog_style[0], $yacht_rental_columns
						)
					);
					do_action( 'yacht_rental_action_after_post_meta' );
				}
			}

			// Post title
			if ( apply_filters( 'yacht_rental_filter_show_blog_title', true, 'classic' ) ) {
				do_action( 'yacht_rental_action_before_post_title' );
				if ( empty( $yacht_rental_template_args['no_links'] ) ) {
					the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
				} else {
					the_title( '<h4 class="post_title entry-title">', '</h4>' );
				}
				do_action( 'yacht_rental_action_after_post_title' );
			}

			if( !in_array( $yacht_rental_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
				// More button
				if ( apply_filters( 'yacht_rental_filter_show_blog_readmore', ! $yacht_rental_show_title || ! empty( $yacht_rental_template_args['more_button'] ), 'classic' ) ) {
					if ( empty( $yacht_rental_template_args['no_links'] ) ) {
						do_action( 'yacht_rental_action_before_post_readmore' );
						yacht_rental_show_post_more_link( $yacht_rental_template_args, '<div class="more-wrap">', '</div>' );
						do_action( 'yacht_rental_action_after_post_readmore' );
					}
				}
			}
			?>
		</div><!-- .entry-header -->
		<?php
	}

	// Post content
	if( in_array( $yacht_rental_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
		ob_start();
		if (apply_filters('yacht_rental_filter_show_blog_excerpt', empty($yacht_rental_template_args['hide_excerpt']) && yacht_rental_get_theme_option('excerpt_length') > 0, 'classic')) {
			yacht_rental_show_post_content($yacht_rental_template_args, '<div class="post_content_inner">', '</div>');
		}
		// More button
		if(! empty( $yacht_rental_template_args['more_button'] )) {
			if ( empty( $yacht_rental_template_args['no_links'] ) ) {
				do_action( 'yacht_rental_action_before_post_readmore' );
				yacht_rental_show_post_more_link( $yacht_rental_template_args, '<div class="more-wrap">', '</div>' );
				do_action( 'yacht_rental_action_after_post_readmore' );
			}
		}
		$yacht_rental_content = ob_get_contents();
		ob_end_clean();
		yacht_rental_show_layout($yacht_rental_content, '<div class="post_content entry-content">', '</div><!-- .entry-content -->');
	}
	?>

</article></div><?php
// Need opening PHP-tag above, because <div> is a inline-block element (used as column)!
