<?php
/**
 * The custom template to display the content
 *
 * Used for index/archive/search.
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0.50
 */

$yacht_rental_template_args = get_query_var( 'yacht_rental_template_args' );
if ( is_array( $yacht_rental_template_args ) ) {
	$yacht_rental_columns    = empty( $yacht_rental_template_args['columns'] ) ? 2 : max( 1, $yacht_rental_template_args['columns'] );
	$yacht_rental_blog_style = array( $yacht_rental_template_args['type'], $yacht_rental_columns );
} else {
	$yacht_rental_template_args = array();
	$yacht_rental_blog_style = explode( '_', yacht_rental_get_theme_option( 'blog_style' ) );
	$yacht_rental_columns    = empty( $yacht_rental_blog_style[1] ) ? 2 : max( 1, $yacht_rental_blog_style[1] );
}
$yacht_rental_blog_id       = yacht_rental_get_custom_blog_id( join( '_', $yacht_rental_blog_style ) );
$yacht_rental_blog_style[0] = str_replace( 'blog-custom-', '', $yacht_rental_blog_style[0] );
$yacht_rental_expanded      = ! yacht_rental_sidebar_present() && yacht_rental_get_theme_option( 'expand_content' ) == 'expand';
$yacht_rental_components    = ! empty( $yacht_rental_template_args['meta_parts'] )
							? ( is_array( $yacht_rental_template_args['meta_parts'] )
								? join( ',', $yacht_rental_template_args['meta_parts'] )
								: $yacht_rental_template_args['meta_parts']
								)
							: yacht_rental_array_get_keys_by_value( yacht_rental_get_theme_option( 'meta_parts' ) );
$yacht_rental_post_format   = get_post_format();
$yacht_rental_post_format   = empty( $yacht_rental_post_format ) ? 'standard' : str_replace( 'post-format-', '', $yacht_rental_post_format );

$yacht_rental_blog_meta     = yacht_rental_get_custom_layout_meta( $yacht_rental_blog_id );
$yacht_rental_custom_style  = ! empty( $yacht_rental_blog_meta['scripts_required'] ) ? $yacht_rental_blog_meta['scripts_required'] : 'none';

if ( ! empty( $yacht_rental_template_args['slider'] ) || $yacht_rental_columns > 1 || ! yacht_rental_is_off( $yacht_rental_custom_style ) ) {
	?><div class="
		<?php
		if ( ! empty( $yacht_rental_template_args['slider'] ) ) {
			echo 'slider-slide swiper-slide';
		} else {
			echo esc_attr( ( yacht_rental_is_off( $yacht_rental_custom_style ) ? 'column' : sprintf( '%1$s_item %1$s_item', $yacht_rental_custom_style ) ) . "-1_{$yacht_rental_columns}" );
		}
		?>
	">
	<?php
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
			'post_item post_item_container post_format_' . esc_attr( $yacht_rental_post_format )
					. ' post_layout_custom post_layout_custom_' . esc_attr( $yacht_rental_columns )
					. ' post_layout_' . esc_attr( $yacht_rental_blog_style[0] )
					. ' post_layout_' . esc_attr( $yacht_rental_blog_style[0] ) . '_' . esc_attr( $yacht_rental_columns )
					. ( ! yacht_rental_is_off( $yacht_rental_custom_style )
						? ' post_layout_' . esc_attr( $yacht_rental_custom_style )
							. ' post_layout_' . esc_attr( $yacht_rental_custom_style ) . '_' . esc_attr( $yacht_rental_columns )
						: ''
						)
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
	// Custom layout
	do_action( 'yacht_rental_action_show_layout', $yacht_rental_blog_id, get_the_ID() );
	?>
</article><?php
if ( ! empty( $yacht_rental_template_args['slider'] ) || $yacht_rental_columns > 1 || ! yacht_rental_is_off( $yacht_rental_custom_style ) ) {
	?></div><?php
	// Need opening PHP-tag above just after </div>, because <div> is a inline-block element (used as column)!
}
