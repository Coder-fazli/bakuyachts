<?php
/**
 * The Sticky template to display the sticky posts
 *
 * Used for index/archive
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0
 */

$yacht_rental_columns     = max( 1, min( 3, count( get_option( 'sticky_posts' ) ) ) );
$yacht_rental_post_format = get_post_format();
$yacht_rental_post_format = empty( $yacht_rental_post_format ) ? 'standard' : str_replace( 'post-format-', '', $yacht_rental_post_format );

?><div class="column-1_<?php echo esc_attr( $yacht_rental_columns ); ?>"><article id="post-<?php the_ID(); ?>" 
	<?php
	post_class( 'post_item post_layout_sticky post_format_' . esc_attr( $yacht_rental_post_format ) );
	yacht_rental_add_blog_animation( $yacht_rental_template_args );
	?>
>

	<?php
	if ( is_sticky() && is_home() && ! is_paged() ) {
		?>
		<span class="post_label label_sticky"></span>
		<?php
	}

	// Featured image
	yacht_rental_show_post_featured(
		array(
			'thumb_size' => yacht_rental_get_thumb_size( 1 == $yacht_rental_columns ? 'big' : ( 2 == $yacht_rental_columns ? 'med' : 'avatar' ) ),
		)
	);

	if ( ! in_array( $yacht_rental_post_format, array( 'link', 'aside', 'status', 'quote' ) ) ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			the_title( sprintf( '<h5 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h6>' );
			// Post meta
			yacht_rental_show_post_meta( apply_filters( 'yacht_rental_filter_post_meta_args', array(), 'sticky', $yacht_rental_columns ) );
			?>
		</div><!-- .entry-header -->
		<?php
	}
	?>
</article></div><?php

// div.column-1_X is a inline-block and new lines and spaces after it are forbidden
