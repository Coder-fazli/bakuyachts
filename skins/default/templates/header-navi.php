<?php
/**
 * The template to display the main menu
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0
 */
?>
<div class="top_panel_navi sc_layouts_row sc_layouts_row_type_compact sc_layouts_row_fixed sc_layouts_row_fixed_always sc_layouts_row_delimiter
	<?php
	if ( yacht_rental_is_on( yacht_rental_get_theme_option( 'header_mobile_enabled' ) ) ) {
		?>
		sc_layouts_hide_on_mobile
		<?php
	}
	?>
">
	<div class="content_wrap">
		<div class="columns_wrap columns_fluid">
			<div class="sc_layouts_column sc_layouts_column_align_left sc_layouts_column_icons_position_left sc_layouts_column_fluid column-1_4">
				<div class="sc_layouts_item">
					<?php
					// Logo
					get_template_part( apply_filters( 'yacht_rental_filter_get_template_part', 'templates/header-logo' ) );
					?>
				</div>
			</div><div class="sc_layouts_column sc_layouts_column_align_right sc_layouts_column_icons_position_left sc_layouts_column_fluid column-3_4">
				<div class="sc_layouts_item">
					<?php
					// Main menu
					$yacht_rental_menu_main = yacht_rental_get_nav_menu( 'menu_main' );
					// Show any menu if no menu selected in the location 'menu_main'
					if ( yacht_rental_get_theme_setting( 'autoselect_menu' ) && empty( $yacht_rental_menu_main ) ) {
						$yacht_rental_menu_main = yacht_rental_get_nav_menu();
					}
					yacht_rental_show_layout(
						$yacht_rental_menu_main,
						'<nav class="menu_main_nav_area sc_layouts_menu sc_layouts_menu_default sc_layouts_hide_on_mobile"'
							. ( yacht_rental_is_on( yacht_rental_get_theme_option( 'seo_snippets' ) ) ? ' itemscope="itemscope" itemtype="' . esc_attr( yacht_rental_get_protocol( true ) ) . '//schema.org/SiteNavigationElement"' : '' )
							. '>',
						'</nav>'
					);
					// Mobile menu button
					?>
					<div class="sc_layouts_iconed_text sc_layouts_menu_mobile_button">
						<a class="sc_layouts_item_link sc_layouts_iconed_text_link" href="#">
							<span class="sc_layouts_item_icon sc_layouts_iconed_text_icon trx_addons_icon-menu"></span>
						</a>
					</div>
				</div><?php
				if ( yacht_rental_exists_trx_addons() ) {
					/*
					// Display cart button
					ob_start();
					do_action( 'yacht_rental_action_cart' );
					$yacht_rental_action_output = ob_get_contents();
					ob_end_clean();
					if ( ! empty( $yacht_rental_action_output ) ) {
						?><div class="sc_layouts_item">
							<?php
							yacht_rental_show_layout( $yacht_rental_action_output );
							?>
							</div><?php
					}
					*/
					?>
                    <div class="sc_layouts_item">
                        <a href="https://wa.me/994704043700" class="sc_layouts_item_link yr-whatsapp-btn" target="_blank">WHATSAPP</a>
                    </div>
                    <?php
				}
				?>
			</div>
		</div>
	</div>
</div>