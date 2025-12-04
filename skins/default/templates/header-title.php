<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0
 */

// Page (category, tag, archive, author) title

if ( yacht_rental_need_page_title() ) {
	yacht_rental_sc_layouts_showed( 'title', true );
	yacht_rental_sc_layouts_showed( 'postmeta', true );
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php
						// Post meta on the single post
						if ( is_single() ) {
							?>
							<div class="sc_layouts_title_meta">
							<?php
								yacht_rental_show_post_meta(
									apply_filters(
										'yacht_rental_filter_post_meta_args', array(
											'components' => join( ',', yacht_rental_array_get_keys_by_value( yacht_rental_get_theme_option( 'meta_parts' ) ) ),
											'counters'   => join( ',', yacht_rental_array_get_keys_by_value( yacht_rental_get_theme_option( 'counters' ) ) ),
											'seo'        => yacht_rental_is_on( yacht_rental_get_theme_option( 'seo_snippets' ) ),
										), 'header', 1
									)
								);
							?>
							</div>
							<?php
						}

						// Blog/Post title
						?>
						<div class="sc_layouts_title_title">
							<?php
							$yacht_rental_blog_title           = yacht_rental_get_blog_title();
							$yacht_rental_blog_title_text      = '';
							$yacht_rental_blog_title_class     = '';
							$yacht_rental_blog_title_link      = '';
							$yacht_rental_blog_title_link_text = '';
							if ( is_array( $yacht_rental_blog_title ) ) {
								$yacht_rental_blog_title_text      = $yacht_rental_blog_title['text'];
								$yacht_rental_blog_title_class     = ! empty( $yacht_rental_blog_title['class'] ) ? ' ' . $yacht_rental_blog_title['class'] : '';
								$yacht_rental_blog_title_link      = ! empty( $yacht_rental_blog_title['link'] ) ? $yacht_rental_blog_title['link'] : '';
								$yacht_rental_blog_title_link_text = ! empty( $yacht_rental_blog_title['link_text'] ) ? $yacht_rental_blog_title['link_text'] : '';
							} else {
								$yacht_rental_blog_title_text = $yacht_rental_blog_title;
							}
							?>
							<h1 class="sc_layouts_title_caption<?php echo esc_attr( $yacht_rental_blog_title_class ); ?>"<?php
								if ( yacht_rental_is_on( yacht_rental_get_theme_option( 'seo_snippets' ) ) ) {
									?> itemprop="headline"<?php
								}
							?>>
								<?php
								$yacht_rental_top_icon = yacht_rental_get_term_image_small();
								if ( ! empty( $yacht_rental_top_icon ) ) {
									$yacht_rental_attr = yacht_rental_getimagesize( $yacht_rental_top_icon );
									?>
									<img src="<?php echo esc_url( $yacht_rental_top_icon ); ?>" alt="<?php esc_attr_e( 'Site icon', 'yacht-rental' ); ?>"
										<?php
										if ( ! empty( $yacht_rental_attr[3] ) ) {
											yacht_rental_show_layout( $yacht_rental_attr[3] );
										}
										?>
									>
									<?php
								}
								echo wp_kses_data( $yacht_rental_blog_title_text );
								?>
							</h1>
							<?php
							if ( ! empty( $yacht_rental_blog_title_link ) && ! empty( $yacht_rental_blog_title_link_text ) ) {
								?>
								<a href="<?php echo esc_url( $yacht_rental_blog_title_link ); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html( $yacht_rental_blog_title_link_text ); ?></a>
								<?php
							}

							// Category/Tag description
							if ( ! is_paged() && ( is_category() || is_tag() || is_tax() ) ) {
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
							}

							?>
						</div>
						<?php

						// Breadcrumbs
						ob_start();
						do_action( 'yacht_rental_action_breadcrumbs' );
						$yacht_rental_breadcrumbs = ob_get_contents();
						ob_end_clean();
						yacht_rental_show_layout( $yacht_rental_breadcrumbs, '<div class="sc_layouts_title_breadcrumbs">', '</div>' );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
