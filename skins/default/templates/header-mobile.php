<?php
/**
 * The template to show mobile header (used only header_style == 'default')
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0.39
 */

// Additional info
if ( yacht_rental_is_off( yacht_rental_get_theme_option( 'header_mobile_hide_info' ) ) ) {
	$yacht_rental_info = yacht_rental_get_theme_option( 'header_mobile_additional_info' );
	if ( '' != $yacht_rental_info ) {
		?><div class="top_panel_mobile_info sc_layouts_row sc_layouts_row_type_compact sc_layouts_row_delimiter sc_layouts_hide_on_large sc_layouts_hide_on_desktop sc_layouts_hide_on_notebook sc_layouts_hide_on_tablet">
			<div class="content_wrap">
				<div class="columns_wrap">
					<div class="sc_layouts_column sc_layouts_column_align_center sc_layouts_column_icons_position_left column-1_1"><div class="sc_layouts_item">
						<?php
						yacht_rental_show_layout( $yacht_rental_info );
						?>
						</div><!-- /.sc_layouts_item -->
					</div><!-- /.sc_layouts_column -->
				</div><!-- /.columns_wrap -->
			</div><!-- /.content_wrap -->
		</div><!-- /.sc_layouts_row -->
		<?php
	}
}

// Logo, menu and buttons
?>
<div class="top_panel_mobile_navi sc_layouts_row sc_layouts_row_type_compact sc_layouts_row_delimiter sc_layouts_row_fixed sc_layouts_row_fixed_always sc_layouts_hide_on_large sc_layouts_hide_on_desktop sc_layouts_hide_on_notebook sc_layouts_hide_on_tablet">
	<div class="content_wrap">
		<div class="columns_wrap columns_fluid">
			<div class="sc_layouts_column sc_layouts_column_align_left sc_layouts_column_icons_position_left sc_layouts_column_fluid column-1_3">
				<?php
				// Logo
				if ( yacht_rental_is_off( yacht_rental_get_theme_option( 'header_mobile_hide_logo' ) ) ) {
					?>
					<div class="sc_layouts_item">
						<?php
						set_query_var( 'yacht_rental_logo_args', array( 'type' => 'mobile_header' ) );
						get_template_part( apply_filters( 'yacht_rental_filter_get_template_part', 'templates/header-logo' ) );
						set_query_var( 'yacht_rental_logo_args', array() );
						?>
					</div>
					<?php
				}
				?>
			</div><div class="sc_layouts_column sc_layouts_column_align_right sc_layouts_column_icons_position_left sc_layouts_column_fluid column-2_3">
				<div class="yr-mobile-header-right">
					<?php
					// Language Switcher
					if ( function_exists( 'pll_the_languages' ) ) :
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
						<div class="sc_layouts_item yr-lang-switcher-wrap yr-mobile-lang">
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
										<?php if ( $lang['current_lang'] ) continue; ?>
										<a href="<?php echo esc_url( $lang['url'] ); ?>" class="yr-lang-option">
											<?php if ( $lang['flag'] ) : ?>
												<img src="<?php echo esc_url( $lang['flag'] ); ?>" alt="<?php echo esc_attr( $lang['name'] ); ?>" class="yr-lang-flag">
											<?php endif; ?>
											<span class="yr-lang-code"><?php echo esc_html( strtoupper( $lang['slug'] ) ); ?></span>
										</a>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
					<?php endif; ?>

					<?php // WhatsApp Button ?>
					<div class="sc_layouts_item yr-mobile-whatsapp">
						<a href="https://wa.me/994554401020" class="sc_layouts_item_link yr-whatsapp-btn" target="_blank">WHATSAPP</a>
					</div>

					<?php // Mobile menu button ?>
					<div class="sc_layouts_item yr-mobile-burger">
						<div class="sc_layouts_iconed_text sc_layouts_menu_mobile_button">
							<a class="sc_layouts_item_link sc_layouts_iconed_text_link" href="#">
								<span class="sc_layouts_item_icon sc_layouts_iconed_text_icon trx_addons_icon-menu"></span>
							</a>
						</div>
					</div>
				</div>
			</div><!-- /.sc_layouts_column -->
		</div><!-- /.columns_wrap -->
	</div><!-- /.content_wrap -->
</div><!-- /.sc_layouts_row -->
