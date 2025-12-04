<?php
/**
 * The template to display the side menu
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0
 */
?>
<div class="menu_side_wrap
<?php
echo ' menu_side_' . esc_attr( yacht_rental_get_theme_option( 'menu_side_icons' ) > 0 ? 'icons' : 'dots' );
$yacht_rental_menu_scheme = yacht_rental_get_theme_option( 'menu_scheme' );
$yacht_rental_header_scheme = yacht_rental_get_theme_option( 'header_scheme' );
if ( ! empty( $yacht_rental_menu_scheme ) && ! yacht_rental_is_inherit( $yacht_rental_menu_scheme  ) ) {
	echo ' scheme_' . esc_attr( $yacht_rental_menu_scheme );
} elseif ( ! empty( $yacht_rental_header_scheme ) && ! yacht_rental_is_inherit( $yacht_rental_header_scheme ) ) {
	echo ' scheme_' . esc_attr( $yacht_rental_header_scheme );
}
?>
				">
	<span class="menu_side_button icon-menu-2"></span>

	<div class="menu_side_inner">
		<?php
		// Logo
		set_query_var( 'yacht_rental_logo_args', array( 'type' => 'side' ) );
		get_template_part( apply_filters( 'yacht_rental_filter_get_template_part', 'templates/header-logo' ) );
		set_query_var( 'yacht_rental_logo_args', array() );
		// Main menu button
		?>
		<div class="toc_menu_item"
			<?php
			if ( yacht_rental_mouse_helper_enabled() ) {
				echo ' data-mouse-helper="click" data-mouse-helper-axis="y" data-mouse-helper-text="' . esc_attr__( 'Open main menu', 'yacht-rental' ) . '"';
			}
			?>
		>
			<a href="#" class="toc_menu_description menu_mobile_description"><span class="toc_menu_description_title"><?php esc_html_e( 'Main menu', 'yacht-rental' ); ?></span></a>
			<a class="menu_mobile_button toc_menu_icon icon-menu-2" href="#"></a>
		</div>		
	</div>

</div><!-- /.menu_side_wrap -->
