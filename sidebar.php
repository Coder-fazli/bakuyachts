<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0
 */

if ( yacht_rental_sidebar_present() ) {
	
	$yacht_rental_sidebar_type = yacht_rental_get_theme_option( 'sidebar_type' );
	if ( 'custom' == $yacht_rental_sidebar_type && ! yacht_rental_is_layouts_available() ) {
		$yacht_rental_sidebar_type = 'default';
	}
	
	// Catch output to the buffer
	ob_start();
	if ( 'default' == $yacht_rental_sidebar_type ) {
		// Default sidebar with widgets
		$yacht_rental_sidebar_name = yacht_rental_get_theme_option( 'sidebar_widgets' );
		yacht_rental_storage_set( 'current_sidebar', 'sidebar' );
		if ( is_active_sidebar( $yacht_rental_sidebar_name ) ) {
			dynamic_sidebar( $yacht_rental_sidebar_name );
		}
	} else {
		// Custom sidebar from Layouts Builder
		$yacht_rental_sidebar_id = yacht_rental_get_custom_sidebar_id();
		do_action( 'yacht_rental_action_show_layout', $yacht_rental_sidebar_id );
	}
	$yacht_rental_out = trim( ob_get_contents() );
	ob_end_clean();
	
	// If any html is present - display it
	if ( ! empty( $yacht_rental_out ) ) {
		$yacht_rental_sidebar_position    = yacht_rental_get_theme_option( 'sidebar_position' );
		$yacht_rental_sidebar_position_ss = yacht_rental_get_theme_option( 'sidebar_position_ss', 'below' );
		?>
		<div class="sidebar widget_area
			<?php
			echo ' ' . esc_attr( $yacht_rental_sidebar_position );
			echo ' sidebar_' . esc_attr( $yacht_rental_sidebar_position_ss );
			echo ' sidebar_' . esc_attr( $yacht_rental_sidebar_type );

			$yacht_rental_sidebar_scheme = apply_filters( 'yacht_rental_filter_sidebar_scheme', yacht_rental_get_theme_option( 'sidebar_scheme', 'inherit' ) );
			if ( ! empty( $yacht_rental_sidebar_scheme ) && ! yacht_rental_is_inherit( $yacht_rental_sidebar_scheme ) && 'custom' != $yacht_rental_sidebar_type ) {
				echo ' scheme_' . esc_attr( $yacht_rental_sidebar_scheme );
			}
			?>
		" role="complementary">
			<?php

			// Skip link anchor to fast access to the sidebar from keyboard
			?>
			<a id="sidebar_skip_link_anchor" class="yacht_rental_skip_link_anchor" href="#"></a>
			<?php

			do_action( 'yacht_rental_action_before_sidebar_wrap', 'sidebar' );

			// Button to show/hide sidebar on mobile
			if ( in_array( $yacht_rental_sidebar_position_ss, array( 'above', 'float' ) ) ) {
				$yacht_rental_title = apply_filters( 'yacht_rental_filter_sidebar_control_title', 'float' == $yacht_rental_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'yacht-rental' ) : '' );
				$yacht_rental_text  = apply_filters( 'yacht_rental_filter_sidebar_control_text', 'above' == $yacht_rental_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'yacht-rental' ) : '' );
				?>
				<a href="#" class="sidebar_control" title="<?php echo esc_attr( $yacht_rental_title ); ?>"><?php echo esc_html( $yacht_rental_text ); ?></a>
				<?php
			}
			?>
			<div class="sidebar_inner">
				<?php
				do_action( 'yacht_rental_action_before_sidebar', 'sidebar' );
				yacht_rental_show_layout( preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $yacht_rental_out ) );
				do_action( 'yacht_rental_action_after_sidebar', 'sidebar' );
				?>
			</div>
			<?php

			do_action( 'yacht_rental_action_after_sidebar_wrap', 'sidebar' );

			?>
		</div>
		<div class="clearfix"></div>
		<?php
	}
}
