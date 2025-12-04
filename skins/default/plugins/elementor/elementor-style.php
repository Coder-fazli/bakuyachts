<?php
// Add plugin-specific fonts to the custom CSS
if ( ! function_exists( 'yacht_rental_elm_get_css' ) ) {
    add_filter( 'yacht_rental_filter_get_css', 'yacht_rental_elm_get_css', 10, 2 );
    function yacht_rental_elm_get_css( $css, $args ) {

        if ( isset( $css['fonts'] ) && isset( $args['fonts'] ) ) {
            $fonts         = $args['fonts'];
            $css['fonts'] .= <<<CSS
.elementor-widget-progress .elementor-title,
.elementor-widget-progress .elementor-progress-percentage,
.elementor-widget-toggle .elementor-toggle-title,
.elementor-widget-tabs .elementor-tab-title,
.elementor-widget-counter .elementor-counter-number-wrapper {
	{$fonts['h5_font-family']}
}
.custom_icon_btn.elementor-widget-button .elementor-button .elementor-button-text,
.elementor-widget-counter .elementor-counter-title,
.elementor-widget-icon-box .elementor-widget-container .elementor-icon-box-title small {
    {$fonts['p_font-family']}
}

CSS;
        }

        return $css;
    }
}


// Add theme-specific CSS-animations
if ( ! function_exists( 'yacht_rental_elm_add_theme_animations' ) ) {
	add_filter( 'elementor/controls/animations/additional_animations', 'yacht_rental_elm_add_theme_animations' );
	function yacht_rental_elm_add_theme_animations( $animations ) {
		/* To add a theme-specific animations to the list:
			1) Merge to the array 'animations': array(
													esc_html__( 'Theme Specific', 'yacht-rental' ) => array(
														'ta_custom_1' => esc_html__( 'Custom 1', 'yacht-rental' )
													)
												)
			2) Add a CSS rules for the class '.ta_custom_1' to create a custom entrance animation
		*/
		$animations = array_merge(
						$animations,
						array(
							esc_html__( 'Theme Specific', 'yacht-rental' ) => array(
									'ta_under_strips' => esc_html__( 'Under the strips', 'yacht-rental' ),
									'yacht-rental-fadeinup' => esc_html__( 'Yacht Rental - Fade In Up', 'yacht-rental' ),
									'yacht-rental-fadeinright' => esc_html__( 'Yacht Rental - Fade In Right', 'yacht-rental' ),
									'yacht-rental-fadeinleft' => esc_html__( 'Yacht Rental - Fade In Left', 'yacht-rental' ),
									'yacht-rental-fadeindown' => esc_html__( 'Yacht Rental - Fade In Down', 'yacht-rental' ),
									'yacht-rental-fadein' => esc_html__( 'Yacht Rental - Fade In', 'yacht-rental' ),
									'yacht-rental-infinite-rotate' => esc_html__( 'Yacht Rental - Infinite Rotate', 'yacht-rental' ),
								)
							)
						);

		return $animations;
	}
}
