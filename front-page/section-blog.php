<div class="front_page_section front_page_section_blog<?php
	$yacht_rental_scheme = yacht_rental_get_theme_option( 'front_page_blog_scheme' );
	if ( ! empty( $yacht_rental_scheme ) && ! yacht_rental_is_inherit( $yacht_rental_scheme ) ) {
		echo ' scheme_' . esc_attr( $yacht_rental_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( yacht_rental_get_theme_option( 'front_page_blog_paddings' ) );
	if ( yacht_rental_get_theme_option( 'front_page_blog_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$yacht_rental_css      = '';
		$yacht_rental_bg_image = yacht_rental_get_theme_option( 'front_page_blog_bg_image' );
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
	$yacht_rental_anchor_icon = yacht_rental_get_theme_option( 'front_page_blog_anchor_icon' );
	$yacht_rental_anchor_text = yacht_rental_get_theme_option( 'front_page_blog_anchor_text' );
if ( ( ! empty( $yacht_rental_anchor_icon ) || ! empty( $yacht_rental_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_blog"'
									. ( ! empty( $yacht_rental_anchor_icon ) ? ' icon="' . esc_attr( $yacht_rental_anchor_icon ) . '"' : '' )
									. ( ! empty( $yacht_rental_anchor_text ) ? ' title="' . esc_attr( $yacht_rental_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_blog_inner
	<?php
	if ( yacht_rental_get_theme_option( 'front_page_blog_fullheight' ) ) {
		echo ' yacht-rental-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$yacht_rental_css      = '';
			$yacht_rental_bg_mask  = yacht_rental_get_theme_option( 'front_page_blog_bg_mask' );
			$yacht_rental_bg_color_type = yacht_rental_get_theme_option( 'front_page_blog_bg_color_type' );
			if ( 'custom' == $yacht_rental_bg_color_type ) {
				$yacht_rental_bg_color = yacht_rental_get_theme_option( 'front_page_blog_bg_color' );
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
		<div class="front_page_section_content_wrap front_page_section_blog_content_wrap content_wrap">
			<?php
			// Caption
			$yacht_rental_caption = yacht_rental_get_theme_option( 'front_page_blog_caption' );
			if ( ! empty( $yacht_rental_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<h2 class="front_page_section_caption front_page_section_blog_caption front_page_block_<?php echo ! empty( $yacht_rental_caption ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( $yacht_rental_caption, 'yacht_rental_kses_content' ); ?></h2>
				<?php
			}

			// Description (text)
			$yacht_rental_description = yacht_rental_get_theme_option( 'front_page_blog_description' );
			if ( ! empty( $yacht_rental_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_description front_page_section_blog_description front_page_block_<?php echo ! empty( $yacht_rental_description ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( wpautop( $yacht_rental_description ), 'yacht_rental_kses_content' ); ?></div>
				<?php
			}

			// Content (widgets)
			?>
			<div class="front_page_section_output front_page_section_blog_output">
				<?php
				if ( is_active_sidebar( 'front_page_blog_widgets' ) ) {
					dynamic_sidebar( 'front_page_blog_widgets' );
				} elseif ( current_user_can( 'edit_theme_options' ) ) {
					if ( ! yacht_rental_exists_trx_addons() ) {
						yacht_rental_customizer_need_trx_addons_message();
					} else {
						yacht_rental_customizer_need_widgets_message( 'front_page_blog_caption', 'ThemeREX Addons - Blogger' );
					}
				}
				?>
			</div>
		</div>
	</div>
</div>
