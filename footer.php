<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0
 */

							do_action( 'yacht_rental_action_page_content_end_text' );
							
							// Widgets area below the content
							yacht_rental_create_widgets_area( 'widgets_below_content' );
						
							do_action( 'yacht_rental_action_page_content_end' );
							?>
						</div>
						<?php
						
						do_action( 'yacht_rental_action_after_page_content' );

						// Show main sidebar
						get_sidebar();

						do_action( 'yacht_rental_action_content_wrap_end' );
						?>
					</div>
					<?php

					do_action( 'yacht_rental_action_after_content_wrap' );

					// Widgets area below the page and related posts below the page
					$yacht_rental_body_style = yacht_rental_get_theme_option( 'body_style' );
					$yacht_rental_widgets_name = yacht_rental_get_theme_option( 'widgets_below_page', 'hide' );
					$yacht_rental_show_widgets = ! yacht_rental_is_off( $yacht_rental_widgets_name ) && is_active_sidebar( $yacht_rental_widgets_name );
					$yacht_rental_show_related = yacht_rental_is_single() && yacht_rental_get_theme_option( 'related_position', 'below_content' ) == 'below_page';
					if ( $yacht_rental_show_widgets || $yacht_rental_show_related ) {
						if ( 'fullscreen' != $yacht_rental_body_style ) {
							?>
							<div class="content_wrap">
							<?php
						}
						// Show related posts before footer
						if ( $yacht_rental_show_related ) {
							do_action( 'yacht_rental_action_related_posts' );
						}

						// Widgets area below page content
						if ( $yacht_rental_show_widgets ) {
							yacht_rental_create_widgets_area( 'widgets_below_page' );
						}
						if ( 'fullscreen' != $yacht_rental_body_style ) {
							?>
							</div>
							<?php
						}
					}
					do_action( 'yacht_rental_action_page_content_wrap_end' );
					?>
			</div>
			<?php
			do_action( 'yacht_rental_action_after_page_content_wrap' );

			// Don't display the footer elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ( ! yacht_rental_is_singular( 'post' ) && ! yacht_rental_is_singular( 'attachment' ) ) || ! in_array ( yacht_rental_get_value_gp( 'action' ), array( 'full_post_loading', 'prev_post_loading' ) ) ) {
				
				// Skip link anchor to fast access to the footer from keyboard
				?>
				<a id="footer_skip_link_anchor" class="yacht_rental_skip_link_anchor" href="#"></a>
				<?php

				do_action( 'yacht_rental_action_before_footer' );

				// Footer
				$yacht_rental_footer_type = yacht_rental_get_theme_option( 'footer_type' );
				if ( 'custom' == $yacht_rental_footer_type && ! yacht_rental_is_layouts_available() ) {
					$yacht_rental_footer_type = 'default';
				}
				get_template_part( apply_filters( 'yacht_rental_filter_get_template_part', "templates/footer-" . sanitize_file_name( $yacht_rental_footer_type ) ) );

				do_action( 'yacht_rental_action_after_footer' );

			}
			?>

			<?php do_action( 'yacht_rental_action_page_wrap_end' ); ?>

		</div>

		<?php do_action( 'yacht_rental_action_after_page_wrap' ); ?>

	</div>

	<?php do_action( 'yacht_rental_action_after_body' ); ?>

	<?php wp_footer(); ?>

</body>
</html>