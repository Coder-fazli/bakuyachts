<?php
$yacht_rental_woocommerce_sc = yacht_rental_get_theme_option( 'front_page_woocommerce_products' );
if ( ! empty( $yacht_rental_woocommerce_sc ) ) {
	?><div class="front_page_section front_page_section_woocommerce<?php
		$yacht_rental_scheme = yacht_rental_get_theme_option( 'front_page_woocommerce_scheme' );
		if ( ! empty( $yacht_rental_scheme ) && ! yacht_rental_is_inherit( $yacht_rental_scheme ) ) {
			echo ' scheme_' . esc_attr( $yacht_rental_scheme );
		}
		echo ' front_page_section_paddings_' . esc_attr( yacht_rental_get_theme_option( 'front_page_woocommerce_paddings' ) );
		if ( yacht_rental_get_theme_option( 'front_page_woocommerce_stack' ) ) {
			echo ' sc_stack_section_on';
		}
	?>"
			<?php
			$yacht_rental_css      = '';
			$yacht_rental_bg_image = yacht_rental_get_theme_option( 'front_page_woocommerce_bg_image' );
			if ( ! empty( $yacht_rental_bg_image ) ) {
				$yacht_rental_css .= 'background-image: url(' . esc_url( yacht_rental_get_attachment_url( $yacht_rental_bg_image ) ) . ');';
			}
			if ( ! empty( $yacht_rental_css ) ) {
				echo ' style="' . esc_attr( $yacht_rental_css ) . '"';
			}
			?>
	>
	<?php
		// Add anchor
		$yacht_rental_anchor_icon = yacht_rental_get_theme_option( 'front_page_woocommerce_anchor_icon' );
		$yacht_rental_anchor_text = yacht_rental_get_theme_option( 'front_page_woocommerce_anchor_text' );
		if ( ( ! empty( $yacht_rental_anchor_icon ) || ! empty( $yacht_rental_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
			echo do_shortcode(
				'[trx_sc_anchor id="front_page_section_woocommerce"'
											. ( ! empty( $yacht_rental_anchor_icon ) ? ' icon="' . esc_attr( $yacht_rental_anchor_icon ) . '"' : '' )
											. ( ! empty( $yacht_rental_anchor_text ) ? ' title="' . esc_attr( $yacht_rental_anchor_text ) . '"' : '' )
											. ']'
			);
		}
	?>
		<div class="front_page_section_inner front_page_section_woocommerce_inner
			<?php
			if ( yacht_rental_get_theme_option( 'front_page_woocommerce_fullheight' ) ) {
				echo ' yacht-rental-full-height sc_layouts_flex sc_layouts_columns_middle';
			}
			?>
				"
				<?php
				$yacht_rental_css      = '';
				$yacht_rental_bg_mask  = yacht_rental_get_theme_option( 'front_page_woocommerce_bg_mask' );
				$yacht_rental_bg_color_type = yacht_rental_get_theme_option( 'front_page_woocommerce_bg_color_type' );
				if ( 'custom' == $yacht_rental_bg_color_type ) {
					$yacht_rental_bg_color = yacht_rental_get_theme_option( 'front_page_woocommerce_bg_color' );
				} elseif ( 'scheme_bg_color' == $yacht_rental_bg_color_type ) {
					$yacht_rental_bg_color = yacht_rental_get_scheme_color( 'bg_color', $yacht_rental_scheme );
				} else {
					$yacht_rental_bg_color = '';
				}
				if ( ! empty( $yacht_rental_bg_color ) && $yacht_rental_bg_mask > 0 ) {
					$yacht_rental_css .= 'background-color: ' . esc_attr(
						1 == $yacht_rental_bg_mask ? $yacht_rental_bg_color : yacht_rental_hex2rgba( $yacht_rental_bg_color, $yacht_rental_bg_mask )
					) . ';';
				}
				if ( ! empty( $yacht_rental_css ) ) {
					echo ' style="' . esc_attr( $yacht_rental_css ) . '"';
				}
				?>
		>
			<div class="front_page_section_content_wrap front_page_section_woocommerce_content_wrap content_wrap woocommerce">
				<?php
				// Content wrap with title and description
				$yacht_rental_caption     = yacht_rental_get_theme_option( 'front_page_woocommerce_caption' );
				$yacht_rental_description = yacht_rental_get_theme_option( 'front_page_woocommerce_description' );
				if ( ! empty( $yacht_rental_caption ) || ! empty( $yacht_rental_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					// Caption
					if ( ! empty( $yacht_rental_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
						?>
						<h2 class="front_page_section_caption front_page_section_woocommerce_caption front_page_block_<?php echo ! empty( $yacht_rental_caption ) ? 'filled' : 'empty'; ?>">
						<?php
							echo wp_kses( $yacht_rental_caption, 'yacht_rental_kses_content' );
						?>
						</h2>
						<?php
					}

					// Description (text)
					if ( ! empty( $yacht_rental_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
						?>
						<div class="front_page_section_description front_page_section_woocommerce_description front_page_block_<?php echo ! empty( $yacht_rental_description ) ? 'filled' : 'empty'; ?>">
						<?php
							echo wp_kses( wpautop( $yacht_rental_description ), 'yacht_rental_kses_content' );
						?>
						</div>
						<?php
					}
				}

				// Content (widgets)
				?>
				<div class="front_page_section_output front_page_section_woocommerce_output list_products shop_mode_thumbs">
					<?php
					if ( 'products' == $yacht_rental_woocommerce_sc ) {
						$yacht_rental_woocommerce_sc_ids      = yacht_rental_get_theme_option( 'front_page_woocommerce_products_per_page' );
						$yacht_rental_woocommerce_sc_per_page = count( explode( ',', $yacht_rental_woocommerce_sc_ids ) );
					} else {
						$yacht_rental_woocommerce_sc_per_page = max( 1, (int) yacht_rental_get_theme_option( 'front_page_woocommerce_products_per_page' ) );
					}
					$yacht_rental_woocommerce_sc_columns = max( 1, min( $yacht_rental_woocommerce_sc_per_page, (int) yacht_rental_get_theme_option( 'front_page_woocommerce_products_columns' ) ) );
					echo do_shortcode(
						"[{$yacht_rental_woocommerce_sc}"
										. ( 'products' == $yacht_rental_woocommerce_sc
												? ' ids="' . esc_attr( $yacht_rental_woocommerce_sc_ids ) . '"'
												: '' )
										. ( 'product_category' == $yacht_rental_woocommerce_sc
												? ' category="' . esc_attr( yacht_rental_get_theme_option( 'front_page_woocommerce_products_categories' ) ) . '"'
												: '' )
										. ( 'best_selling_products' != $yacht_rental_woocommerce_sc
												? ' orderby="' . esc_attr( yacht_rental_get_theme_option( 'front_page_woocommerce_products_orderby' ) ) . '"'
													. ' order="' . esc_attr( yacht_rental_get_theme_option( 'front_page_woocommerce_products_order' ) ) . '"'
												: '' )
										. ' per_page="' . esc_attr( $yacht_rental_woocommerce_sc_per_page ) . '"'
										. ' columns="' . esc_attr( $yacht_rental_woocommerce_sc_columns ) . '"'
						. ']'
					);
					?>
				</div>
			</div>
		</div>
	</div>
	<?php
}
