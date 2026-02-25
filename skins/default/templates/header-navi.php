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
				<div class="sc_layouts_item yr-menu-item">
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
					?>
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
                    <div class="sc_layouts_item yr-lang-switcher-wrap">
                        <?php if ( function_exists( 'pll_the_languages' ) ) : ?>
                            <?php
                            $languages = pll_the_languages( array( 'raw' => 1 ) );
                            $current_lang = pll_current_language( 'slug' );
                            $current_flag = '';
                            $current_name = strtoupper( $current_lang );

                            foreach ( $languages as $lang ) {
                                if ( $lang['slug'] === $current_lang ) {
                                    $current_flag = $lang['flag'];
                                    break;
                                }
                            }
                            ?>
                            <div class="yr-lang-switcher">
                                <button class="yr-lang-current" type="button">
                                    <?php if ( $current_flag ) : ?>
                                        <img src="<?php echo esc_url( $current_flag ); ?>" alt="<?php echo esc_attr( $current_name ); ?>" class="yr-lang-flag">
                                    <?php endif; ?>
                                    <span class="yr-lang-code"><?php echo esc_html( $current_name ); ?></span>
                                    <svg class="yr-lang-arrow" width="10" height="6" viewBox="0 0 10 6" fill="none"><path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </button>
                                <div class="yr-lang-dropdown">
                                    <?php foreach ( $languages as $lang ) : ?>
                                        <?php if ( $lang['current_lang'] ) continue; // Skip current language ?>
                                        <a href="<?php echo esc_url( $lang['url'] ); ?>" class="yr-lang-option">
                                            <?php if ( $lang['flag'] ) : ?>
                                                <img src="<?php echo esc_url( $lang['flag'] ); ?>" alt="<?php echo esc_attr( $lang['name'] ); ?>" class="yr-lang-flag">
                                            <?php endif; ?>
                                            <span class="yr-lang-code"><?php echo esc_html( strtoupper( $lang['slug'] ) ); ?></span>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="sc_layouts_item yr-whatsapp-item">
                        <a href="https://wa.me/994554401020" class="sc_layouts_item_link yr-whatsapp-btn" target="_blank">WHATSAPP</a>
                    </div>
                    <?php
				}
				?>
				<!-- Mobile menu button (separate item for proper mobile alignment) -->
				<div class="sc_layouts_item yr-burger-item">
					<div class="sc_layouts_iconed_text sc_layouts_menu_mobile_button">
						<a class="sc_layouts_item_link sc_layouts_iconed_text_link" href="#">
							<span class="sc_layouts_item_icon sc_layouts_iconed_text_icon trx_addons_icon-menu"></span>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>