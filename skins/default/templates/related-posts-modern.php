<?php
/**
 * The template 'Style 1' to displaying related posts
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0
 */

$yacht_rental_link        = get_permalink();
$yacht_rental_post_format = get_post_format();
$yacht_rental_post_format = empty( $yacht_rental_post_format ) ? 'standard' : str_replace( 'post-format-', '', $yacht_rental_post_format );
?><div id="post-<?php the_ID(); ?>" <?php post_class( 'related_item post_format_' . esc_attr( $yacht_rental_post_format ) ); ?> data-post-id="<?php the_ID(); ?>">
	<?php
	yacht_rental_show_post_featured(
		array(
			'thumb_size'    => apply_filters( 'yacht_rental_filter_related_thumb_size', yacht_rental_get_thumb_size( (int) yacht_rental_get_theme_option( 'related_posts' ) == 1 ? 'huge' : 'big' ) ),
			'post_info'     => '<div class="post_header entry-header">'
									. '<div class="post_categories">' . wp_kses( yacht_rental_get_post_categories( '' ), 'yacht_rental_kses_content' ) . '</div>'
									. '<h6 class="post_title entry-title"><a href="' . esc_url( $yacht_rental_link ) . '">'
										. wp_kses_data( '' == get_the_title() ? esc_html__( '- No title -', 'yacht-rental' ) : get_the_title() )
									. '</a></h6>'
									. ( in_array( get_post_type(), array( 'post', 'attachment' ) )
											? '<div class="post_meta"><a href="' . esc_url( $yacht_rental_link ) . '" class="post_meta_item post_date">' . wp_kses_data( yacht_rental_get_date() ) . '</a></div>'
											: '' )
								. '</div>',
		)
	);
	?>
</div>
