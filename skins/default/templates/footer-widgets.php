<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0.10
 */

// Footer sidebar
$yacht_rental_footer_name    = yacht_rental_get_theme_option( 'footer_widgets' );
$yacht_rental_footer_present = ! yacht_rental_is_off( $yacht_rental_footer_name ) && is_active_sidebar( $yacht_rental_footer_name );
if ( $yacht_rental_footer_present ) {
	yacht_rental_storage_set( 'current_sidebar', 'footer' );
	$yacht_rental_footer_wide = yacht_rental_get_theme_option( 'footer_wide' );
	ob_start();
	if ( is_active_sidebar( $yacht_rental_footer_name ) ) {
		dynamic_sidebar( $yacht_rental_footer_name );
	}
	$yacht_rental_out = trim( ob_get_contents() );
	ob_end_clean();
	if ( ! empty( $yacht_rental_out ) ) {
		$yacht_rental_out          = preg_replace( "/<\\/aside>[\r\n\s]*<aside/", '</aside><aside', $yacht_rental_out );
		$yacht_rental_need_columns = true;   //or check: strpos($yacht_rental_out, 'columns_wrap')===false;
		if ( $yacht_rental_need_columns ) {
			$yacht_rental_columns = max( 0, (int) yacht_rental_get_theme_option( 'footer_columns' ) );			
			if ( 0 == $yacht_rental_columns ) {
				$yacht_rental_columns = min( 4, max( 1, yacht_rental_tags_count( $yacht_rental_out, 'aside' ) ) );
			}
			if ( $yacht_rental_columns > 1 ) {
				$yacht_rental_out = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $yacht_rental_columns ) . ' widget', $yacht_rental_out );
			} else {
				$yacht_rental_need_columns = false;
			}
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo ! empty( $yacht_rental_footer_wide ) ? ' footer_fullwidth' : ''; ?> sc_layouts_row sc_layouts_row_type_normal">
			<?php do_action( 'yacht_rental_action_before_sidebar_wrap', 'footer' ); ?>
			<div class="footer_widgets_inner widget_area_inner">
				<?php
				if ( ! $yacht_rental_footer_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $yacht_rental_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'yacht_rental_action_before_sidebar', 'footer' );
				yacht_rental_show_layout( $yacht_rental_out );
				do_action( 'yacht_rental_action_after_sidebar', 'footer' );
				if ( $yacht_rental_need_columns ) {
					?>
					</div><!-- /.columns_wrap -->
					<?php
				}
				if ( ! $yacht_rental_footer_wide ) {
					?>
					</div><!-- /.content_wrap -->
					<?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
			<?php do_action( 'yacht_rental_action_after_sidebar_wrap', 'footer' ); ?>
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
