<?php
/**
 * The template 'Style 2' to displaying related posts
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
			'thumb_ratio'   => '300:223',
			'thumb_size'    => apply_filters( 'yacht_rental_filter_related_thumb_size', yacht_rental_get_thumb_size( (int) yacht_rental_get_theme_option( 'related_posts' ) == 1 ? 'huge' : 'square' ) ),
		)
	);
	?>
	<div class="post_header entry-header">
		<?php
		if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {

			yacht_rental_show_post_meta(
				array(
					'components' => 'categories',
					'class'      => 'post_meta_categories',
				)
			);

		}
		?>
		<h6 class="post_title entry-title"><a href="<?php echo esc_url( $yacht_rental_link ); ?>"><?php
			if ( '' == get_the_title() ) {
				esc_html_e( '- No title -', 'yacht-rental' );
			} else {
				the_title();
			}
		?></a></h6>
	</div>
</div>
