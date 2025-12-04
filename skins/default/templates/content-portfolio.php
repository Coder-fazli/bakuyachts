<?php
/**
 * The Portfolio template to display the content
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

$yacht_rental_post_format = get_post_format();
$yacht_rental_post_format = empty( $yacht_rental_post_format ) ? 'standard' : str_replace( 'post-format-', '', $yacht_rental_post_format );

?><div class="
<?php
if ( ! empty( $yacht_rental_template_args['slider'] ) ) {
	echo ' slider-slide swiper-slide';
} else {
	echo ( yacht_rental_is_blog_style_use_masonry( $yacht_rental_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $yacht_rental_columns ) : esc_attr( $yacht_rental_columns_class ));
}
?>
"><article id="post-<?php the_ID(); ?>" 
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $yacht_rental_post_format )
		. ' post_layout_portfolio'
		. ' post_layout_portfolio_' . esc_attr( $yacht_rental_columns )
		. ( 'portfolio' != $yacht_rental_blog_style[0] ? ' ' . esc_attr( $yacht_rental_blog_style[0] )  . '_' . esc_attr( $yacht_rental_columns ) : '' )
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

	$yacht_rental_hover   = ! empty( $yacht_rental_template_args['hover'] ) && ! yacht_rental_is_inherit( $yacht_rental_template_args['hover'] )
								? $yacht_rental_template_args['hover']
								: yacht_rental_get_theme_option( 'image_hover' );

	if ( 'dots' == $yacht_rental_hover ) {
		$yacht_rental_post_link = empty( $yacht_rental_template_args['no_links'] )
								? ( ! empty( $yacht_rental_template_args['link'] )
									? $yacht_rental_template_args['link']
									: get_permalink()
									)
								: '';
		$yacht_rental_target    = ! empty( $yacht_rental_post_link ) && yacht_rental_is_external_url( $yacht_rental_post_link )
								? ' target="_blank" rel="nofollow"'
								: '';
	}
	
	// Meta parts
	$yacht_rental_components = ! empty( $yacht_rental_template_args['meta_parts'] )
							? ( is_array( $yacht_rental_template_args['meta_parts'] )
								? $yacht_rental_template_args['meta_parts']
								: explode( ',', $yacht_rental_template_args['meta_parts'] )
								)
							: yacht_rental_array_get_keys_by_value( yacht_rental_get_theme_option( 'meta_parts' ) );

	// Featured image
	yacht_rental_show_post_featured( apply_filters( 'yacht_rental_filter_args_featured',
        array(
			'hover'         => $yacht_rental_hover,
			'no_links'      => ! empty( $yacht_rental_template_args['no_links'] ),
			'thumb_size'    => ! empty( $yacht_rental_template_args['thumb_size'] )
								? $yacht_rental_template_args['thumb_size']
								: yacht_rental_get_thumb_size(
									yacht_rental_is_blog_style_use_masonry( $yacht_rental_blog_style[0] )
										? (	strpos( yacht_rental_get_theme_option( 'body_style' ), 'full' ) !== false || $yacht_rental_columns < 3
											? 'masonry-big'
											: 'masonry'
											)
										: (	strpos( yacht_rental_get_theme_option( 'body_style' ), 'full' ) !== false || $yacht_rental_columns < 3
											? 'square'
											: 'square'
											)
								),
			'thumb_bg' => yacht_rental_is_blog_style_use_masonry( $yacht_rental_blog_style[0] ) ? false : true,
			'show_no_image' => true,
			'meta_parts'    => $yacht_rental_components,
			'class'         => 'dots' == $yacht_rental_hover ? 'hover_with_info' : '',
			'post_info'     => 'dots' == $yacht_rental_hover
										? '<div class="post_info"><h5 class="post_title">'
											. ( ! empty( $yacht_rental_post_link )
												? '<a href="' . esc_url( $yacht_rental_post_link ) . '"' . ( ! empty( $target ) ? $target : '' ) . '>'
												: ''
												)
												. esc_html( get_the_title() ) 
											. ( ! empty( $yacht_rental_post_link )
												? '</a>'
												: ''
												)
											. '</h5></div>'
										: '',
            'thumb_ratio'   => 'info' == $yacht_rental_hover ?  '100:102' : '',
        ),
        'content-portfolio',
        $yacht_rental_template_args
    ) );
	?>
</article></div><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!