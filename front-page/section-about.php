<div class="front_page_section front_page_section_about<?php
	$yacht_rental_scheme = yacht_rental_get_theme_option( 'front_page_about_scheme' );
	if ( ! empty( $yacht_rental_scheme ) && ! yacht_rental_is_inherit( $yacht_rental_scheme ) ) {
		echo ' scheme_' . esc_attr( $yacht_rental_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( yacht_rental_get_theme_option( 'front_page_about_paddings' ) );
	if ( yacht_rental_get_theme_option( 'front_page_about_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$yacht_rental_css      = '';
		$yacht_rental_bg_image = yacht_rental_get_theme_option( 'front_page_about_bg_image' );
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
	$yacht_rental_anchor_icon = yacht_rental_get_theme_option( 'front_page_about_anchor_icon' );
	$yacht_rental_anchor_text = yacht_rental_get_theme_option( 'front_page_about_anchor_text' );
if ( ( ! empty( $yacht_rental_anchor_icon ) || ! empty( $yacht_rental_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_about"'
									. ( ! empty( $yacht_rental_anchor_icon ) ? ' icon="' . esc_attr( $yacht_rental_anchor_icon ) . '"' : '' )
									. ( ! empty( $yacht_rental_anchor_text ) ? ' title="' . esc_attr( $yacht_rental_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_about_inner
	<?php
	if ( yacht_rental_get_theme_option( 'front_page_about_fullheight' ) ) {
		echo ' yacht-rental-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$yacht_rental_css           = '';
			$yacht_rental_bg_mask       = yacht_rental_get_theme_option( 'front_page_about_bg_mask' );
			$yacht_rental_bg_color_type = yacht_rental_get_theme_option( 'front_page_about_bg_color_type' );
			if ( 'custom' == $yacht_rental_bg_color_type ) {
				$yacht_rental_bg_color = yacht_rental_get_theme_option( 'front_page_about_bg_color' );
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
		<div class="front_page_section_content_wrap front_page_section_about_content_wrap content_wrap">
			<?php
			// Caption
			$yacht_rental_caption = yacht_rental_get_theme_option( 'front_page_about_caption' );
			if ( ! empty( $yacht_rental_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<h2 class="front_page_section_caption front_page_section_about_caption front_page_block_<?php echo ! empty( $yacht_rental_caption ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( $yacht_rental_caption, 'yacht_rental_kses_content' ); ?></h2>
				<?php
			}

			// Description (text)
			$yacht_rental_description = yacht_rental_get_theme_option( 'front_page_about_description' );
			if ( ! empty( $yacht_rental_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_description front_page_section_about_description front_page_block_<?php echo ! empty( $yacht_rental_description ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( wpautop( $yacht_rental_description ), 'yacht_rental_kses_content' ); ?></div>
				<?php
			}

			// Content
			$yacht_rental_content = yacht_rental_get_theme_option( 'front_page_about_content' );
			if ( ! empty( $yacht_rental_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_content front_page_section_about_content front_page_block_<?php echo ! empty( $yacht_rental_content ) ? 'filled' : 'empty'; ?>">
					<?php
					$yacht_rental_page_content_mask = '%%CONTENT%%';
					if ( strpos( $yacht_rental_content, $yacht_rental_page_content_mask ) !== false ) {
						$yacht_rental_content = preg_replace(
							'/(\<p\>\s*)?' . $yacht_rental_page_content_mask . '(\s*\<\/p\>)/i',
							sprintf(
								'<div class="front_page_section_about_source">%s</div>',
								apply_filters( 'the_content', get_the_content() )
							),
							$yacht_rental_content
						);
					}
					yacht_rental_show_layout( $yacht_rental_content );
					?>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</div>
