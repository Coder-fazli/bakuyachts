<div class="front_page_section front_page_section_googlemap<?php
	$yacht_rental_scheme = yacht_rental_get_theme_option( 'front_page_googlemap_scheme' );
	if ( ! empty( $yacht_rental_scheme ) && ! yacht_rental_is_inherit( $yacht_rental_scheme ) ) {
		echo ' scheme_' . esc_attr( $yacht_rental_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( yacht_rental_get_theme_option( 'front_page_googlemap_paddings' ) );
	if ( yacht_rental_get_theme_option( 'front_page_googlemap_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$yacht_rental_css      = '';
		$yacht_rental_bg_image = yacht_rental_get_theme_option( 'front_page_googlemap_bg_image' );
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
	$yacht_rental_anchor_icon = yacht_rental_get_theme_option( 'front_page_googlemap_anchor_icon' );
	$yacht_rental_anchor_text = yacht_rental_get_theme_option( 'front_page_googlemap_anchor_text' );
if ( ( ! empty( $yacht_rental_anchor_icon ) || ! empty( $yacht_rental_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_googlemap"'
									. ( ! empty( $yacht_rental_anchor_icon ) ? ' icon="' . esc_attr( $yacht_rental_anchor_icon ) . '"' : '' )
									. ( ! empty( $yacht_rental_anchor_text ) ? ' title="' . esc_attr( $yacht_rental_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_googlemap_inner
		<?php
		$yacht_rental_layout = yacht_rental_get_theme_option( 'front_page_googlemap_layout' );
		echo ' front_page_section_layout_' . esc_attr( $yacht_rental_layout );
		if ( yacht_rental_get_theme_option( 'front_page_googlemap_fullheight' ) ) {
			echo ' yacht-rental-full-height sc_layouts_flex sc_layouts_columns_middle';
		}
		?>
		"
			<?php
			$yacht_rental_css      = '';
			$yacht_rental_bg_mask  = yacht_rental_get_theme_option( 'front_page_googlemap_bg_mask' );
			$yacht_rental_bg_color_type = yacht_rental_get_theme_option( 'front_page_googlemap_bg_color_type' );
			if ( 'custom' == $yacht_rental_bg_color_type ) {
				$yacht_rental_bg_color = yacht_rental_get_theme_option( 'front_page_googlemap_bg_color' );
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
		<div class="front_page_section_content_wrap front_page_section_googlemap_content_wrap
		<?php
		if ( 'fullwidth' != $yacht_rental_layout ) {
			echo ' content_wrap';
		}
		?>
		">
			<?php
			// Content wrap with title and description
			$yacht_rental_caption     = yacht_rental_get_theme_option( 'front_page_googlemap_caption' );
			$yacht_rental_description = yacht_rental_get_theme_option( 'front_page_googlemap_description' );
			if ( ! empty( $yacht_rental_caption ) || ! empty( $yacht_rental_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				if ( 'fullwidth' == $yacht_rental_layout ) {
					?>
					<div class="content_wrap">
					<?php
				}
					// Caption
				if ( ! empty( $yacht_rental_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<h2 class="front_page_section_caption front_page_section_googlemap_caption front_page_block_<?php echo ! empty( $yacht_rental_caption ) ? 'filled' : 'empty'; ?>">
					<?php
					echo wp_kses( $yacht_rental_caption, 'yacht_rental_kses_content' );
					?>
					</h2>
					<?php
				}

					// Description (text)
				if ( ! empty( $yacht_rental_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<div class="front_page_section_description front_page_section_googlemap_description front_page_block_<?php echo ! empty( $yacht_rental_description ) ? 'filled' : 'empty'; ?>">
					<?php
					echo wp_kses( wpautop( $yacht_rental_description ), 'yacht_rental_kses_content' );
					?>
					</div>
					<?php
				}
				if ( 'fullwidth' == $yacht_rental_layout ) {
					?>
					</div>
					<?php
				}
			}

			// Content (text)
			$yacht_rental_content = yacht_rental_get_theme_option( 'front_page_googlemap_content' );
			if ( ! empty( $yacht_rental_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				if ( 'columns' == $yacht_rental_layout ) {
					?>
					<div class="front_page_section_columns front_page_section_googlemap_columns columns_wrap">
						<div class="column-1_3">
					<?php
				} elseif ( 'fullwidth' == $yacht_rental_layout ) {
					?>
					<div class="content_wrap">
					<?php
				}

				?>
				<div class="front_page_section_content front_page_section_googlemap_content front_page_block_<?php echo ! empty( $yacht_rental_content ) ? 'filled' : 'empty'; ?>">
				<?php
					echo wp_kses( $yacht_rental_content, 'yacht_rental_kses_content' );
				?>
				</div>
				<?php

				if ( 'columns' == $yacht_rental_layout ) {
					?>
					</div><div class="column-2_3">
					<?php
				} elseif ( 'fullwidth' == $yacht_rental_layout ) {
					?>
					</div>
					<?php
				}
			}

			// Widgets output
			?>
			<div class="front_page_section_output front_page_section_googlemap_output">
				<?php
				if ( is_active_sidebar( 'front_page_googlemap_widgets' ) ) {
					dynamic_sidebar( 'front_page_googlemap_widgets' );
				} elseif ( current_user_can( 'edit_theme_options' ) ) {
					if ( ! yacht_rental_exists_trx_addons() ) {
						yacht_rental_customizer_need_trx_addons_message();
					} else {
						yacht_rental_customizer_need_widgets_message( 'front_page_googlemap_caption', 'ThemeREX Addons - Google map' );
					}
				}
				?>
			</div>
			<?php

			if ( 'columns' == $yacht_rental_layout && ( ! empty( $yacht_rental_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				</div></div>
				<?php
			}
			?>
		</div>
	</div>
</div>
