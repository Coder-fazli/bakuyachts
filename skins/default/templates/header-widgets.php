<?php
/**
 * The template to display the widgets area in the header
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0
 */

// Header sidebar
$yacht_rental_header_name    = yacht_rental_get_theme_option( 'header_widgets' );
$yacht_rental_header_present = ! yacht_rental_is_off( $yacht_rental_header_name ) && is_active_sidebar( $yacht_rental_header_name );
if ( $yacht_rental_header_present ) {
	yacht_rental_storage_set( 'current_sidebar', 'header' );
	$yacht_rental_header_wide = yacht_rental_get_theme_option( 'header_wide' );
	ob_start();
	if ( is_active_sidebar( $yacht_rental_header_name ) ) {
		dynamic_sidebar( $yacht_rental_header_name );
	}
	$yacht_rental_widgets_output = ob_get_contents();
	ob_end_clean();
	if ( ! empty( $yacht_rental_widgets_output ) ) {
		$yacht_rental_widgets_output = preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $yacht_rental_widgets_output );
		$yacht_rental_need_columns   = strpos( $yacht_rental_widgets_output, 'columns_wrap' ) === false;
		if ( $yacht_rental_need_columns ) {
			$yacht_rental_columns = max( 0, (int) yacht_rental_get_theme_option( 'header_columns' ) );
			if ( 0 == $yacht_rental_columns ) {
				$yacht_rental_columns = min( 6, max( 1, yacht_rental_tags_count( $yacht_rental_widgets_output, 'aside' ) ) );
			}
			if ( $yacht_rental_columns > 1 ) {
				$yacht_rental_widgets_output = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $yacht_rental_columns ) . ' widget', $yacht_rental_widgets_output );
			} else {
				$yacht_rental_need_columns = false;
			}
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo ! empty( $yacht_rental_header_wide ) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<?php do_action( 'yacht_rental_action_before_sidebar_wrap', 'header' ); ?>
			<div class="header_widgets_inner widget_area_inner">
				<?php
				if ( ! $yacht_rental_header_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $yacht_rental_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'yacht_rental_action_before_sidebar', 'header' );
				yacht_rental_show_layout( $yacht_rental_widgets_output );
				do_action( 'yacht_rental_action_after_sidebar', 'header' );
				if ( $yacht_rental_need_columns ) {
					?>
					</div>	<!-- /.columns_wrap -->
					<?php
				}
				if ( ! $yacht_rental_header_wide ) {
					?>
					</div>	<!-- /.content_wrap -->
					<?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
			<?php do_action( 'yacht_rental_action_after_sidebar_wrap', 'header' ); ?>
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
