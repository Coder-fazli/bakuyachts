<?php
/**
 * Yacht Rental Child Theme Functions
 *
 * All custom CPTs, shortcodes, styles, and modifications.
 * The parent theme handles core functionality; this file adds everything custom.
 *
 * @package YACHT RENTAL CHILD
 * @since 1.0.0
 */

// Define child theme directory constants
if ( ! defined( 'YR_CHILD_DIR' ) ) {
	define( 'YR_CHILD_DIR', trailingslashit( get_stylesheet_directory() ) );
}
if ( ! defined( 'YR_CHILD_URL' ) ) {
	define( 'YR_CHILD_URL', trailingslashit( get_stylesheet_directory_uri() ) );
}

// =====================================================
// ENQUEUE PARENT + CHILD STYLES
// =====================================================

function yr_child_enqueue_styles() {
	wp_enqueue_style(
		'yacht-rental-parent-style',
		get_template_directory_uri() . '/style.css',
		array(),
		wp_get_theme( 'yacht-rental' )->get( 'Version' )
	);
	wp_enqueue_style(
		'yacht-rental-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		array( 'yacht-rental-parent-style' ),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'yr_child_enqueue_styles' );

// =====================================================
// CUSTOM POST TYPES & SHORTCODES
// =====================================================

// Custom Post Type: Yachts
require_once YR_CHILD_DIR . 'includes/cpt-yachts.php';

// Custom Post Type: Packages
require_once YR_CHILD_DIR . 'includes/cpt-packages.php';

// Custom Post Type: Hero Sections
require_once YR_CHILD_DIR . 'includes/cpt-hero-section.php';

// Custom Post Type: Gallery
require_once YR_CHILD_DIR . 'includes/cpt-gallery.php';

// Custom Post Type: Slider
require_once YR_CHILD_DIR . 'includes/cpt-slider.php';

// Custom Post Type: Partners
require_once YR_CHILD_DIR . 'includes/cpt-founder.php';
require_once YR_CHILD_DIR . 'includes/cpt-partners.php';

// Custom Post Type: Services
require_once YR_CHILD_DIR . 'includes/cpt-services.php';

// Custom Meta Boxes: About Page (now handled via 'about' CPT)
require_once YR_CHILD_DIR . 'includes/cpt-about-meta.php';

// Shortcode: About Page [yacht_about]
require_once YR_CHILD_DIR . 'includes/shortcode-about.php';

// Preloader
require_once YR_CHILD_DIR . 'includes/preloader.php';

// =====================================================
// DEQUEUE CONFLICTING SCRIPTS ON YACHT ARCHIVE
// =====================================================

if ( ! function_exists( 'yacht_rental_dequeue_yacht_archive_conflicts' ) ) {
	add_action( 'wp_enqueue_scripts', 'yacht_rental_dequeue_yacht_archive_conflicts', 9999 );

	function yacht_rental_dequeue_yacht_archive_conflicts() {
		if ( ! is_post_type_archive( 'cpt_yachts' ) ) {
			return;
		}

		// Dequeue ThemeREX Addons scripts that cause scroll jumping
		wp_dequeue_script( 'trx_addons-init' );
		wp_dequeue_script( 'trx_addons-parallax' );
		wp_dequeue_script( 'trx_addons-mouse-parallax' );
		wp_dequeue_script( 'trx_addons-scroll' );

		// Dequeue Elementor frontend scripts
		wp_dequeue_script( 'elementor-frontend' );
		wp_dequeue_script( 'elementor-waypoints' );
		wp_dequeue_script( 'elementor-pro-frontend' );

		// Dequeue Swiper / slider scripts
		wp_dequeue_script( 'swiper' );
		wp_dequeue_script( 'trx_addons-swiper' );

		// Dequeue masonry and parallax scripts
		wp_dequeue_script( 'imagesloaded' );
		wp_dequeue_script( 'masonry' );
	}
}

// =====================================================
// MOBILE HEADER HEIGHT REDUCTION
// =====================================================

if ( ! function_exists( 'yacht_rental_mobile_header_styles' ) ) {
	add_action( 'wp_head', 'yacht_rental_mobile_header_styles', 100 );

	function yacht_rental_mobile_header_styles() {
		?>
		<style id="yacht-rental-mobile-header-styles">
			/* Header padding */
			.top_panel_navi.sc_layouts_row {
				padding-top: 15px !important;
				padding-bottom: 15px !important;
			}

			/* Desktop: show menu, hide burger */
			@media (min-width: 768px) {
				.top_panel_navi .yr-menu-item {
					display: block !important;
				}
				.top_panel_navi .yr-burger-item {
					display: none !important;
				}
			}

			/* Reduce header height on mobile */
			@media (max-width: 767px) {
				.top_panel_navi.sc_layouts_row {
					padding-top: 10px !important;
					padding-bottom: 10px !important;
				}

				.top_panel,
				.sc_layouts_row {
					padding-top: 8px !important;
					padding-bottom: 8px !important;
				}

				/* =============================================
				   FIX: All header items on ONE LINE (mobile)
				   ============================================= */

				/* Make columns stay on same row */
				.top_panel_navi .columns_wrap {
					display: flex !important;
					flex-wrap: nowrap !important;
					align-items: center !important;
				}

				/* Logo column - auto width */
				.top_panel_navi .sc_layouts_column_align_left {
					width: auto !important;
					flex: 0 0 auto !important;
				}

				/* Right column - take remaining space, align right */
				.top_panel_navi .sc_layouts_column_align_right {
					width: auto !important;
					flex: 1 1 auto !important;
					display: flex !important;
					flex-direction: row !important;
					flex-wrap: nowrap !important;
					align-items: center !important;
					justify-content: flex-end !important;
					gap: 6px !important;
				}

				.top_panel_navi .sc_layouts_column_align_right > .sc_layouts_item {
					display: inline-flex !important;
					align-items: center !important;
					flex-shrink: 0 !important;
					margin: 0 !important;
					padding: 0 !important;
				}

				/* Hide the main menu container on mobile */
				.top_panel_navi .yr-menu-item {
					display: none !important;
				}

				/* Language switcher - order 1 */
				.top_panel_navi .yr-lang-switcher-wrap {
					order: 1 !important;
					display: inline-flex !important;
				}
				.top_panel_navi .yr-lang-current {
					padding: 4px 6px !important;
					font-size: 10px !important;
					gap: 3px !important;
				}
				.top_panel_navi .yr-lang-flag {
					width: 14px !important;
					height: 10px !important;
				}
				.top_panel_navi .yr-lang-arrow {
					width: 8px !important;
					height: 5px !important;
				}

				/* WhatsApp button - order 2, smaller */
				.top_panel_navi .yr-whatsapp-item {
					order: 2 !important;
					display: inline-flex !important;
				}
				.top_panel_navi .yr-whatsapp-btn {
					padding: 5px 8px !important;
					font-size: 9px !important;
					border-radius: 4px !important;
					box-shadow: none !important;
				}

				/* Burger menu - order 3 (last) */
				.top_panel_navi .yr-burger-item {
					order: 3 !important;
					display: inline-flex !important;
				}
				.top_panel_navi .yr-burger-item .sc_layouts_item_icon {
					font-size: 18px !important;
				}

				/* Logo smaller on mobile */
				.top_panel_navi .sc_layouts_logo img {
					max-height: 35px !important;
				}
				.sc_layouts_row_type_normal {
					padding-top: 10px !important;
					padding-bottom: 10px !important;
				}
				.sc_layouts_row_type_compact {
					padding-top: 6px !important;
					padding-bottom: 6px !important;
				}
				.sc_layouts_logo img,
				.custom-logo-link img {
					max-height: 40px !important;
				}
				.sc_layouts_row .elementor-widget-wrap {
					padding-top: 0 !important;
					padding-bottom: 0 !important;
				}
				.sc_layouts_menu_mobile_button .sc_layouts_item_icon {
					font-size: 20px !important;
				}

				/* Align header columns vertically */
				.sc_layouts_row .elementor-container,
				.sc_layouts_row .elementor-row {
					align-items: center !important;
				}
				.sc_layouts_row .elementor-column {
					display: flex !important;
					align-items: center !important;
				}
				.sc_layouts_row .elementor-column-wrap,
				.sc_layouts_row .elementor-widget-wrap {
					display: flex !important;
					align-items: center !important;
					width: 100% !important;
				}

				/* Fix right column vertical position */
				.sc_layouts_column_align_right {
					margin-top: 0 !important;
					margin-bottom: 0 !important;
					padding-top: 0 !important;
					padding-bottom: 0 !important;
				}
				.sc_layouts_column_align_right .elementor-column-wrap,
				.sc_layouts_column_align_right .elementor-widget-wrap {
					margin-top: 0 !important;
					margin-bottom: 0 !important;
					padding-top: 0 !important;
					padding-bottom: 0 !important;
				}
				.sc_layouts_column_align_right .elementor-widget-wrap > .elementor-element {
					margin-top: 0 !important;
					margin-bottom: 0 !important;
					padding-top: 0 !important;
					padding-bottom: 0 !important;
				}
				.sc_layouts_column_align_right .sc_layouts_item,
				.sc_layouts_column_align_right .sc_socials,
				.sc_layouts_column_align_right .sc_layouts_menu_mobile_button {
					margin-top: 0 !important;
					margin-bottom: 0 !important;
					padding-top: 0 !important;
					padding-bottom: 0 !important;
				}

				/* Move WhatsApp button before burger menu */
				.sc_layouts_column_align_right .elementor-widget-wrap {
					flex-direction: row !important;
					flex-wrap: nowrap !important;
					justify-content: flex-end !important;
				}
				.sc_layouts_column_align_right .elementor-widget-wrap > .elementor-element {
					width: auto !important;
					flex-shrink: 0 !important;
				}
				/* WhatsApp/social buttons come first */
				.sc_layouts_column_align_right .elementor-widget-wrap > .elementor-widget-trx_sc_socials,
				.sc_layouts_column_align_right .elementor-widget-wrap > .elementor-widget-trx_sc_button {
					order: 1 !important;
					margin-right: 10px !important;
				}
				/* Burger menu comes last */
				.sc_layouts_column_align_right .elementor-widget-wrap > .elementor-widget-trx_sc_layouts_menu {
					order: 10 !important;
					margin-right: 0 !important;
				}
			}

			/* Tablet adjustments */
			@media (max-width: 1023px) and (min-width: 768px) {
				.top_panel,
				.sc_layouts_row {
					padding-top: 10px !important;
					padding-bottom: 10px !important;
				}
				.sc_layouts_logo img,
				.custom-logo-link img {
					max-height: 50px !important;
				}

				/* Align header columns vertically */
				.sc_layouts_row .elementor-container,
				.sc_layouts_row .elementor-row {
					align-items: center !important;
				}
				.sc_layouts_row .elementor-column {
					display: flex !important;
					align-items: center !important;
				}
				.sc_layouts_row .elementor-column-wrap,
				.sc_layouts_row .elementor-widget-wrap {
					display: flex !important;
					align-items: center !important;
				}

				/* Fix right column vertical position */
				.sc_layouts_column_align_right {
					margin-top: 0 !important;
					margin-bottom: 0 !important;
					padding-top: 0 !important;
					padding-bottom: 0 !important;
				}
				.sc_layouts_column_align_right .elementor-column-wrap,
				.sc_layouts_column_align_right .elementor-widget-wrap {
					margin-top: 0 !important;
					margin-bottom: 0 !important;
					padding-top: 0 !important;
					padding-bottom: 0 !important;
				}
				.sc_layouts_column_align_right .elementor-widget-wrap > .elementor-element {
					margin-top: 0 !important;
					margin-bottom: 0 !important;
					padding-top: 0 !important;
					padding-bottom: 0 !important;
				}
				.sc_layouts_column_align_right .sc_layouts_item,
				.sc_layouts_column_align_right .sc_socials,
				.sc_layouts_column_align_right .sc_layouts_menu_mobile_button {
					margin-top: 0 !important;
					margin-bottom: 0 !important;
					padding-top: 0 !important;
					padding-bottom: 0 !important;
				}

				/* Move WhatsApp button before burger menu on tablet */
				.sc_layouts_column_align_right .elementor-widget-wrap {
					flex-direction: row !important;
					flex-wrap: nowrap !important;
					justify-content: flex-end !important;
					width: 100% !important;
				}
				.sc_layouts_column_align_right .elementor-widget-wrap > .elementor-element {
					width: auto !important;
					flex-shrink: 0 !important;
					margin-bottom: 0 !important;
				}
				.sc_layouts_column_align_right .elementor-widget-wrap > .elementor-widget-trx_sc_socials,
				.sc_layouts_column_align_right .elementor-widget-wrap > .elementor-widget-trx_sc_button {
					order: 1 !important;
					margin-right: 15px !important;
				}
				.sc_layouts_column_align_right .elementor-widget-wrap > .elementor-widget-trx_sc_layouts_menu {
					order: 10 !important;
					margin-right: 0 !important;
				}
			}

			/* WhatsApp button styling - desktop */
			.top_panel_navi .sc_layouts_column_align_right > .sc_layouts_item {
				display: inline-block !important;
				vertical-align: middle !important;
			}

			.top_panel_navi .yr-whatsapp-btn,
			.top_panel_navi .sc_layouts_item_link[href*="wa.me"] {
				display: inline-flex !important;
				align-items: center !important;
				vertical-align: middle !important;
				background: #25d366 !important;
				color: #fff !important;
				padding: 12px 24px !important;
				border-radius: 8px !important;
				text-decoration: none !important;
				font-weight: 600 !important;
				font-size: 14px !important;
				box-shadow: 0 4px 15px rgba(37, 211, 102, 0.4) !important;
				transition: all 0.3s ease !important;
			}

			.top_panel_navi .yr-whatsapp-btn:hover,
			.top_panel_navi .sc_layouts_item_link[href*="wa.me"]:hover {
				background: #1da851 !important;
				box-shadow: 0 6px 20px rgba(37, 211, 102, 0.5) !important;
				transform: translateY(-2px) !important;
			}

			/* Hide burger on desktop */
			@media (min-width: 1024px) {
				.top_panel_navi .sc_layouts_menu_mobile_button {
					display: none !important;
				}
			}

			@media (max-width: 1023px) {
				/* Show burger and keep WhatsApp side by side on tablet/mobile */
				.top_panel_navi .sc_layouts_column_align_right > .sc_layouts_item {
					display: inline-block !important;
					vertical-align: middle !important;
					margin-left: 8px !important;
				}

				.top_panel_navi .sc_layouts_menu_mobile_button {
					display: inline-block !important;
					vertical-align: middle !important;
				}

				/* Smaller WhatsApp button */
				.top_panel_navi .yr-whatsapp-btn,
				.top_panel_navi .sc_layouts_item_link[href*="wa.me"] {
					padding: 8px 14px !important;
					font-size: 12px !important;
					box-shadow: 0 3px 10px rgba(37, 211, 102, 0.3) !important;
				}
			}

			@media (max-width: 480px) {
				/* Even smaller on very small screens */
				.top_panel_navi .sc_layouts_column_align_right {
					gap: 4px !important;
				}
				.top_panel_navi .yr-whatsapp-btn,
				.top_panel_navi .sc_layouts_item_link[href*="wa.me"] {
					padding: 4px 6px !important;
					font-size: 8px !important;
					box-shadow: none !important;
				}
				.top_panel_navi .yr-lang-current {
					padding: 3px 5px !important;
					font-size: 9px !important;
				}
				.top_panel_navi .yr-lang-flag {
					width: 12px !important;
					height: 9px !important;
				}
				.top_panel_navi .sc_layouts_logo img {
					max-height: 30px !important;
				}
			}

			@media (max-width: 380px) {
				/* Very small screens */
				.top_panel_navi .sc_layouts_column_align_right {
					gap: 3px !important;
				}
				.top_panel_navi .yr-whatsapp-btn {
					padding: 3px 5px !important;
					font-size: 7px !important;
				}
				.top_panel_navi .yr-lang-code {
					display: none !important;
				}
				.top_panel_navi .yr-lang-arrow {
					display: none !important;
				}
				.top_panel_navi .sc_layouts_logo img {
					max-height: 28px !important;
				}
			}

			/* ============================================
			   MOBILE HEADER - All elements on one line
			   ============================================ */
			.top_panel_mobile_navi .yr-mobile-header-right {
				display: flex !important;
				flex-direction: row !important;
				flex-wrap: nowrap !important;
				align-items: center !important;
				justify-content: flex-end !important;
				gap: 8px !important;
			}

			.top_panel_mobile_navi .yr-mobile-header-right .sc_layouts_item {
				display: flex !important;
				align-items: center !important;
				margin: 0 !important;
				padding: 0 !important;
			}

			/* Mobile Language Switcher */
			.top_panel_mobile_navi .yr-mobile-lang {
				order: 1 !important;
			}

			.top_panel_mobile_navi .yr-lang-switcher {
				position: relative;
			}

			.top_panel_mobile_navi .yr-lang-current {
				display: flex !important;
				align-items: center !important;
				gap: 4px !important;
				background: transparent !important;
				border: 1px solid rgba(255,255,255,0.3) !important;
				border-radius: 4px !important;
				padding: 6px 8px !important;
				color: inherit !important;
				cursor: pointer !important;
				font-size: 12px !important;
			}

			.top_panel_mobile_navi .yr-lang-flag {
				width: 18px !important;
				height: 13px !important;
				object-fit: cover !important;
				border-radius: 2px !important;
			}

			.top_panel_mobile_navi .yr-lang-code {
				font-weight: 600 !important;
				font-size: 11px !important;
			}

			.top_panel_mobile_navi .yr-lang-arrow {
				width: 8px !important;
				height: 5px !important;
			}

			.top_panel_mobile_navi .yr-lang-dropdown {
				display: none;
				position: absolute !important;
				top: 100% !important;
				right: 0 !important;
				background: #fff !important;
				border-radius: 4px !important;
				box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
				min-width: 80px !important;
				z-index: 9999 !important;
				margin-top: 4px !important;
			}

			.top_panel_mobile_navi .yr-lang-switcher:hover .yr-lang-dropdown,
			.top_panel_mobile_navi .yr-lang-switcher.active .yr-lang-dropdown {
				display: block !important;
			}

			.top_panel_mobile_navi .yr-lang-option {
				display: flex !important;
				align-items: center !important;
				gap: 6px !important;
				padding: 8px 10px !important;
				color: #333 !important;
				text-decoration: none !important;
				font-size: 12px !important;
			}

			.top_panel_mobile_navi .yr-lang-option:hover {
				background: #f5f5f5 !important;
			}

			/* Mobile WhatsApp Button */
			.top_panel_mobile_navi .yr-mobile-whatsapp {
				order: 2 !important;
			}

			.top_panel_mobile_navi .yr-whatsapp-btn {
				display: inline-flex !important;
				align-items: center !important;
				background: #25d366 !important;
				color: #fff !important;
				padding: 6px 12px !important;
				border-radius: 4px !important;
				text-decoration: none !important;
				font-weight: 600 !important;
				font-size: 10px !important;
				white-space: nowrap !important;
				box-shadow: 0 2px 8px rgba(37, 211, 102, 0.3) !important;
			}

			.top_panel_mobile_navi .yr-whatsapp-btn:hover {
				background: #1da851 !important;
			}

			/* Mobile Burger Menu */
			.top_panel_mobile_navi .yr-mobile-burger {
				order: 3 !important;
			}

			.top_panel_mobile_navi .sc_layouts_menu_mobile_button .sc_layouts_item_icon {
				font-size: 20px !important;
			}

			/* Smaller screens adjustments */
			@media (max-width: 480px) {
				.top_panel_mobile_navi .yr-mobile-header-right {
					gap: 5px !important;
				}

				.top_panel_mobile_navi .yr-whatsapp-btn {
					padding: 5px 8px !important;
					font-size: 9px !important;
				}

				.top_panel_mobile_navi .yr-lang-current {
					padding: 5px 6px !important;
				}

				.top_panel_mobile_navi .yr-lang-code {
					font-size: 10px !important;
				}
			}

			@media (max-width: 360px) {
				.top_panel_mobile_navi .yr-mobile-header-right {
					gap: 3px !important;
				}

				.top_panel_mobile_navi .yr-whatsapp-btn {
					padding: 4px 6px !important;
					font-size: 8px !important;
				}

				.top_panel_mobile_navi .yr-lang-current {
					padding: 4px 5px !important;
				}

				.top_panel_mobile_navi .yr-lang-flag {
					width: 14px !important;
					height: 10px !important;
				}
			}
		</style>
		<?php
	}
}

// =====================================================
// GOOGLE TAG MANAGER
// =====================================================

if ( ! function_exists( 'yacht_rental_gtm_head' ) ) {
	add_action( 'wp_head', 'yacht_rental_gtm_head', 1 );

	function yacht_rental_gtm_head() {
		?>
		<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-PH2FSDL2');</script>
		<!-- End Google Tag Manager -->
		<?php
	}
}

if ( ! function_exists( 'yacht_rental_gtm_body' ) ) {
	add_action( 'wp_body_open', 'yacht_rental_gtm_body', 1 );

	function yacht_rental_gtm_body() {
		?>
		<!-- Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PH2FSDL2"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->
		<?php
	}
}

// =====================================================
// POLYLANG CPT ARCHIVE LANGUAGE SWITCHER FIX
// =====================================================

if ( ! function_exists( 'yr_polylang_archive_switcher_fix' ) ) {
	add_filter( 'pll_the_languages', 'yr_polylang_archive_switcher_fix', 10, 2 );

	function yr_polylang_archive_switcher_fix( $output, $args ) {
		if ( ! is_post_type_archive( array( 'cpt_yachts', 'cpt_packages' ) ) ) {
			return $output;
		}

		if ( ! function_exists( 'pll_the_languages' ) || ! function_exists( 'pll_current_language' ) ) {
			return $output;
		}

		$current_post_type = get_queried_object()->name;
		$current_lang = pll_current_language();

		$languages = pll_the_languages( array( 'raw' => 1 ) );

		if ( empty( $languages ) || ! is_array( $languages ) ) {
			return $output;
		}

		foreach ( $languages as $lang_slug => $lang_data ) {
			$archive_url = get_post_type_archive_link( $current_post_type );

			if ( $lang_slug !== $current_lang ) {
				$home_url = pll_home_url( $lang_slug );

				$post_type_obj = get_post_type_object( $current_post_type );
				$archive_slug = $post_type_obj->rewrite['slug'] ?? $current_post_type;

				$correct_url = trailingslashit( $home_url ) . $archive_slug . '/';

				if ( is_array( $output ) ) {
					if ( isset( $output[ $lang_slug ] ) ) {
						$output[ $lang_slug ]['url'] = $correct_url;
					}
				} else {
					$output = preg_replace(
						'/(<a[^>]*class="[^"]*lang-' . $lang_slug . '[^"]*"[^>]*href=")[^"]*(")/i',
						'$1' . esc_url( $correct_url ) . '$2',
						$output
					);
				}
			}
		}

		return $output;
	}
}

if ( ! function_exists( 'yr_polylang_archive_translation_url' ) ) {
	add_filter( 'pll_translation_url', 'yr_polylang_archive_translation_url', 10, 2 );

	function yr_polylang_archive_translation_url( $url, $lang ) {
		if ( ! is_post_type_archive( array( 'cpt_yachts', 'cpt_packages' ) ) ) {
			return $url;
		}

		if ( ! function_exists( 'pll_home_url' ) ) {
			return $url;
		}

		$current_post_type = get_queried_object()->name;
		$post_type_obj = get_post_type_object( $current_post_type );

		if ( ! $post_type_obj ) {
			return $url;
		}

		$archive_slug = $post_type_obj->rewrite['slug'] ?? $current_post_type;
		$home_url = pll_home_url( $lang );

		$correct_url = trailingslashit( $home_url ) . $archive_slug . '/';

		return $correct_url;
	}
}

// =====================================================
// ABOUT CPT
// =====================================================

function yacht_rental_create_about_post_type() {
    $labels = array(
        'name'                  => _x( 'About', 'Post type general name', 'yacht-rental' ),
        'singular_name'         => _x( 'About', 'Post type singular name', 'yacht-rental' ),
        'menu_name'             => _x( 'About', 'Admin Menu text', 'yacht-rental' ),
        'name_admin_bar'        => _x( 'About', 'Add New on Toolbar', 'yacht-rental' ),
        'add_new'               => __( 'Add New', 'yacht-rental' ),
        'add_new_item'          => __( 'Add New About', 'yacht-rental' ),
        'new_item'              => __( 'New About', 'yacht-rental' ),
        'edit_item'             => __( 'Edit About', 'yacht-rental' ),
        'view_item'             => __( 'View About', 'yacht-rental' ),
        'all_items'             => __( 'All About', 'yacht-rental' ),
        'search_items'          => __( 'Search About', 'yacht-rental' ),
        'parent_item_colon'     => __( 'Parent About:', 'yacht-rental' ),
        'not_found'             => __( 'No About found.', 'yacht-rental' ),
        'not_found_in_trash'    => __( 'No About found in Trash.', 'yacht-rental' ),
        'featured_image'        => _x( 'About Cover Image', 'Overrides the "Featured Image" phrase for this post type.', 'yacht-rental' ),
        'set_featured_image'    => _x( 'Set cover image', 'Overrides the "Set featured image" phrase for this post type.', 'yacht-rental' ),
        'remove_featured_image' => _x( 'Remove cover image', 'Overrides the "Remove featured image" phrase for this post type.', 'yacht-rental' ),
        'use_featured_image'    => _x( 'Use as cover image', 'Overrides the "Use as featured image" phrase for this post type.', 'yacht-rental' ),
        'archives'              => _x( 'About archives', 'The post type archive label used in nav menus.', 'yacht-rental' ),
        'insert_into_item'      => _x( 'Insert into About', 'Overrides the "Insert into post" phrase.', 'yacht-rental' ),
        'uploaded_to_this_item' => _x( 'Uploaded to this About', 'Overrides the "Uploaded to this post" phrase.', 'yacht-rental' ),
        'filter_items_list'     => _x( 'Filter About list', 'Screen reader text for the filter links heading.', 'yacht-rental' ),
        'items_list_navigation' => _x( 'About list navigation', 'Screen reader text for the pagination heading.', 'yacht-rental' ),
        'items_list'            => _x( 'About list', 'Screen reader text for the items list heading.', 'yacht-rental' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'about', 'with_front' => false ),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'supports'           => array( 'title', 'thumbnail', 'editor' ),
        'menu_icon'          => 'dashicons-info-outline',
        'show_in_rest'       => true,
    );

    register_post_type( 'about', $args );
}
add_action( 'init', 'yacht_rental_create_about_post_type' );

// Polylang support for About CPT
function yr_about_polylang_register_cpt( $post_types, $is_settings ) {
    $post_types['about'] = 'about';
    return $post_types;
}
add_filter( 'pll_get_post_types', 'yr_about_polylang_register_cpt', 10, 2 );

function yr_about_polylang_enable_cpt() {
    if ( ! function_exists( 'pll_languages_list' ) ) {
        return;
    }

    $options = get_option( 'polylang' );
    if ( $options && is_array( $options ) ) {
        if ( ! isset( $options['post_types'] ) ) {
            $options['post_types'] = array();
        }
        if ( ! in_array( 'about', $options['post_types'] ) ) {
            $options['post_types'][] = 'about';
            update_option( 'polylang', $options );
        }
    }
}
add_action( 'admin_init', 'yr_about_polylang_enable_cpt' );

// Polylang support for cpt_layouts
function yr_layouts_polylang_register_cpt( $post_types, $is_settings ) {
    $post_types['cpt_layouts'] = 'cpt_layouts';
    return $post_types;
}
add_filter( 'pll_get_post_types', 'yr_layouts_polylang_register_cpt', 10, 2 );

function yr_layouts_polylang_enable_cpt() {
    if ( ! function_exists( 'pll_languages_list' ) ) {
        return;
    }

    $options = get_option( 'polylang' );
    if ( $options && is_array( $options ) ) {
        if ( ! isset( $options['post_types'] ) ) {
            $options['post_types'] = array();
        }
        if ( ! in_array( 'cpt_layouts', $options['post_types'] ) ) {
            $options['post_types'][] = 'cpt_layouts';
            update_option( 'polylang', $options );
        }
    }
}
add_action( 'admin_init', 'yr_layouts_polylang_enable_cpt' );

// Translate layouts (header/footer) using Polylang
function yr_translate_layout_with_polylang( $layout_id ) {
    if ( function_exists( 'pll_get_post' ) && ! empty( $layout_id ) ) {
        $translated_id = pll_get_post( $layout_id );
        if ( ! empty( $translated_id ) ) {
            return $translated_id;
        }
    }
    return $layout_id;
}
add_filter( 'trx_addons_filter_get_translated_post', 'yr_translate_layout_with_polylang', 10, 1 );
add_filter( 'yacht_rental_filter_get_translated_layout', 'yr_translate_layout_with_polylang', 10, 1 );

// =====================================================
// ARCHIVE TITLES SETTINGS (PER LANGUAGE)
// =====================================================

function yr_archive_titles_menu() {
    add_options_page(
        __( 'Archive Titles', 'yacht-rental' ),
        __( 'Archive Titles', 'yacht-rental' ),
        'manage_options',
        'yr-archive-titles',
        'yr_archive_titles_page'
    );
}
add_action( 'admin_menu', 'yr_archive_titles_menu' );

function yr_archive_titles_page() {
    $languages = array( 'en' => 'English' );
    if ( function_exists( 'pll_languages_list' ) ) {
        $pll_languages = pll_languages_list( array( 'fields' => 'slug' ) );
        $languages = array();
        foreach ( $pll_languages as $lang ) {
            $lang_name = strtoupper( $lang );
            if ( function_exists( 'PLL' ) && isset( PLL()->model ) ) {
                $lang_obj = PLL()->model->get_language( $lang );
                if ( $lang_obj ) $lang_name = $lang_obj->name;
            }
            $languages[ $lang ] = $lang_name;
        }
    }

    if ( isset( $_POST['yr_archive_titles_save'] ) && check_admin_referer( 'yr_archive_titles_nonce' ) ) {
        foreach ( $languages as $lang_code => $lang_name ) {
            update_option( "yr_yachts_archive_title_{$lang_code}", sanitize_text_field( $_POST["yr_yachts_title_{$lang_code}"] ?? '' ) );
            update_option( "yr_yachts_archive_subtitle_{$lang_code}", sanitize_text_field( $_POST["yr_yachts_subtitle_{$lang_code}"] ?? '' ) );
            update_option( "yr_packages_archive_title_{$lang_code}", sanitize_text_field( $_POST["yr_packages_title_{$lang_code}"] ?? '' ) );
            update_option( "yr_packages_archive_subtitle_{$lang_code}", sanitize_text_field( $_POST["yr_packages_subtitle_{$lang_code}"] ?? '' ) );
        }
        echo '<div class="notice notice-success"><p>' . __( 'Settings saved!', 'yacht-rental' ) . '</p></div>';
    }
    ?>
    <div class="wrap">
        <h1><?php _e( 'Archive Page Titles', 'yacht-rental' ); ?></h1>
        <form method="post">
            <?php wp_nonce_field( 'yr_archive_titles_nonce' ); ?>
            <?php foreach ( $languages as $lang_code => $lang_name ) : ?>
                <h2 style="margin-top:30px;padding-top:20px;border-top:1px solid #ccc;"><?php echo esc_html( $lang_name ); ?> (<?php echo strtoupper( $lang_code ); ?>)</h2>
                <table class="form-table">
                    <tr><th colspan="2"><strong><?php _e( 'Yachts Archive', 'yacht-rental' ); ?></strong></th></tr>
                    <tr>
                        <th><?php _e( 'H1 Title', 'yacht-rental' ); ?></th>
                        <td><input type="text" name="yr_yachts_title_<?php echo $lang_code; ?>" value="<?php echo esc_attr( get_option( "yr_yachts_archive_title_{$lang_code}", '' ) ); ?>" class="regular-text" placeholder="All Yachts" /></td>
                    </tr>
                    <tr>
                        <th><?php _e( 'Subtitle', 'yacht-rental' ); ?></th>
                        <td><input type="text" name="yr_yachts_subtitle_<?php echo $lang_code; ?>" value="<?php echo esc_attr( get_option( "yr_yachts_archive_subtitle_{$lang_code}", '' ) ); ?>" class="large-text" /></td>
                    </tr>
                    <tr><th colspan="2" style="padding-top:20px;"><strong><?php _e( 'Packages Archive', 'yacht-rental' ); ?></strong></th></tr>
                    <tr>
                        <th><?php _e( 'H1 Title', 'yacht-rental' ); ?></th>
                        <td><input type="text" name="yr_packages_title_<?php echo $lang_code; ?>" value="<?php echo esc_attr( get_option( "yr_packages_archive_title_{$lang_code}", '' ) ); ?>" class="regular-text" placeholder="Our Packages" /></td>
                    </tr>
                    <tr>
                        <th><?php _e( 'Subtitle', 'yacht-rental' ); ?></th>
                        <td><input type="text" name="yr_packages_subtitle_<?php echo $lang_code; ?>" value="<?php echo esc_attr( get_option( "yr_packages_archive_subtitle_{$lang_code}", '' ) ); ?>" class="large-text" /></td>
                    </tr>
                </table>
            <?php endforeach; ?>
            <p class="submit"><input type="submit" name="yr_archive_titles_save" class="button button-primary" value="<?php _e( 'Save Settings', 'yacht-rental' ); ?>" /></p>
        </form>
    </div>
    <?php
}

function yr_get_archive_title( $type = 'yachts', $field = 'title' ) {
    $lang = function_exists( 'pll_current_language' ) ? pll_current_language() : 'en';
    $value = get_option( "yr_{$type}_archive_{$field}_{$lang}", '' );
    if ( empty( $value ) ) {
        if ( $type === 'yachts' && $field === 'title' ) $value = __( 'All Yachts', 'yacht-rental' );
        elseif ( $type === 'packages' && $field === 'title' ) $value = __( 'Our Packages', 'yacht-rental' );
        elseif ( $type === 'packages' && $field === 'subtitle' ) $value = __( 'Choose from our exclusive yacht rental packages', 'yacht-rental' );
        elseif ( $type === 'services' && $field === 'title' ) $value = __( 'Our Services', 'yacht-rental' );
    }
    return $value;
}

// Override Rank Math meta title for yacht/package archives
function yr_archive_seo_title( $title ) {
    if ( is_post_type_archive( 'cpt_yachts' ) ) {
        $custom = yr_get_archive_title( 'yachts', 'meta_title' );
        if ( ! empty( $custom ) ) return $custom;
    } elseif ( is_post_type_archive( 'cpt_packages' ) ) {
        $custom = yr_get_archive_title( 'packages', 'meta_title' );
        if ( ! empty( $custom ) ) return $custom;
    } elseif ( is_post_type_archive( 'bky_services' ) ) {
        $custom = yr_get_archive_title( 'services', 'meta_title' );
        if ( ! empty( $custom ) ) return $custom;
    }
    return $title;
}
add_filter( 'rank_math/frontend/title', 'yr_archive_seo_title', 999 );
add_filter( 'pre_get_document_title', 'yr_archive_seo_title', 999 );

// Also override via document_title_parts for themes that use wp_get_document_title()
function yr_archive_seo_title_parts( $title_parts ) {
    if ( is_post_type_archive( 'cpt_yachts' ) ) {
        $custom = yr_get_archive_title( 'yachts', 'meta_title' );
        if ( ! empty( $custom ) ) {
            $title_parts['title'] = $custom;
            unset( $title_parts['site'] );
        }
    } elseif ( is_post_type_archive( 'cpt_packages' ) ) {
        $custom = yr_get_archive_title( 'packages', 'meta_title' );
        if ( ! empty( $custom ) ) {
            $title_parts['title'] = $custom;
            unset( $title_parts['site'] );
        }
    } elseif ( is_post_type_archive( 'bky_services' ) ) {
        $custom = yr_get_archive_title( 'services', 'meta_title' );
        if ( ! empty( $custom ) ) {
            $title_parts['title'] = $custom;
            unset( $title_parts['site'] );
        }
    }
    return $title_parts;
}
add_filter( 'document_title_parts', 'yr_archive_seo_title_parts', 999 );

// Override Rank Math meta description for yacht/package archives
function yr_archive_seo_description( $desc ) {
    if ( is_post_type_archive( 'cpt_yachts' ) ) {
        $custom = yr_get_archive_title( 'yachts', 'meta_desc' );
        if ( ! empty( $custom ) ) return $custom;
    } elseif ( is_post_type_archive( 'cpt_packages' ) ) {
        $custom = yr_get_archive_title( 'packages', 'meta_desc' );
        if ( ! empty( $custom ) ) return $custom;
    } elseif ( is_post_type_archive( 'bky_services' ) ) {
        $custom = yr_get_archive_title( 'services', 'meta_desc' );
        if ( ! empty( $custom ) ) return $custom;
    }
    return $desc;
}
add_filter( 'rank_math/frontend/description', 'yr_archive_seo_description', 999 );

// Fallback: output meta description tag if Rank Math is not active
function yr_archive_meta_description_fallback() {
    if ( ! class_exists( 'RankMath' ) ) {
        $desc = '';
        if ( is_post_type_archive( 'cpt_yachts' ) ) {
            $desc = yr_get_archive_title( 'yachts', 'meta_desc' );
        } elseif ( is_post_type_archive( 'cpt_packages' ) ) {
            $desc = yr_get_archive_title( 'packages', 'meta_desc' );
        } elseif ( is_post_type_archive( 'bky_services' ) ) {
            $desc = yr_get_archive_title( 'services', 'meta_desc' );
        }
        if ( ! empty( $desc ) ) {
            echo '<meta name="description" content="' . esc_attr( $desc ) . '" />' . "\n";
        }
    }
}
add_action( 'wp_head', 'yr_archive_meta_description_fallback', 1 );

// Filter the theme's blog title for yacht and package archives
function yr_filter_archive_title( $title ) {
    if ( is_post_type_archive( 'cpt_yachts' ) ) {
        $custom_title = yr_get_archive_title( 'yachts', 'title' );
        if ( ! empty( $custom_title ) ) {
            return $custom_title;
        }
    } elseif ( is_post_type_archive( 'cpt_packages' ) ) {
        $custom_title = yr_get_archive_title( 'packages', 'title' );
        if ( ! empty( $custom_title ) ) {
            return $custom_title;
        }
    }
    return $title;
}
add_filter( 'yacht_rental_filter_get_blog_title', 'yr_filter_archive_title', 10, 1 );

// =====================================================
// REGISTER TRANSLATABLE STRINGS WITH POLYLANG
// =====================================================

/**
 * Register button text strings for Polylang String Translations.
 * Go to Languages → String Translations → search "GET IN TOUCH"
 * to translate per language.
 */
function yr_register_polylang_strings() {
	if ( function_exists( 'pll_register_string' ) ) {
		pll_register_string( 'get_in_touch_btn', 'GET IN TOUCH', 'yacht-rental' );
		pll_register_string( 'whatsapp_btn', 'WHATSAPP', 'yacht-rental' );
		pll_register_string( 'view_details_btn', 'VIEW DETAILS', 'yacht-rental' );
		pll_register_string( 'service_whats_included', "What's included", 'yacht-rental' );
		pll_register_string( 'service_about_heading', 'About This Service', 'yacht-rental' );
		pll_register_string( 'service_faq_heading', 'Frequently Asked Questions', 'yacht-rental' );
	}
}
add_action( 'init', 'yr_register_polylang_strings' );

// =====================================================
// TRANSLATE YACHTS CPT BREADCRUMB LABEL PER LANGUAGE
// =====================================================
add_filter( 'post_type_labels_cpt_yachts', 'yr_translate_yachts_labels' );
function yr_translate_yachts_labels( $labels ) {
	if ( ! function_exists( 'pll_current_language' ) ) {
		return $labels;
	}
	$lang = pll_current_language();
	if ( $lang === 'az' ) {
		$labels->name      = 'Yaxtalar';
		$labels->all_items = 'Yaxtalar';
	} elseif ( $lang === 'ru' ) {
		$labels->name      = 'Все яхты';
		$labels->all_items = 'Все яхты';
	}
	return $labels;
}

// =====================================================
// TRANSLATE SERVICES CPT BREADCRUMB LABEL PER LANGUAGE
// =====================================================
add_filter( 'post_type_labels_bky_services', 'yr_translate_services_labels' );
function yr_translate_services_labels( $labels ) {
	if ( ! function_exists( 'pll_current_language' ) ) {
		return $labels;
	}
	$lang = pll_current_language();
	if ( $lang === 'az' ) {
		$labels->name      = 'Xidmətlər';
		$labels->all_items = 'Xidmətlər';
	} elseif ( $lang === 'ru' ) {
		$labels->name      = 'Услуги';
		$labels->all_items = 'Услуги';
	}
	return $labels;
}

// =====================================================
// FORCE DEFAULT HEADER ON ALL CUSTOM CPT PAGES
// =====================================================

/**
 * Force all custom CPT pages to use the default header (with nav, language
 * switcher, and WhatsApp button from child theme's header-navi.php).
 * Without this, CPT pages get the old ThemeREX custom layout header
 * which lacks the language switcher and WhatsApp button.
 *
 * Uses the template_part filter for a reliable override at render time.
 */
function yr_force_default_header_template( $template ) {
	// Only intercept the main header-custom template, not header-navi, header-mobile, etc.
	if ( $template !== 'templates/header-custom' ) {
		return $template;
	}

	$force_default = false;

	// About page
	if ( get_query_var( 'about_page' ) || is_singular( 'about' ) ) {
		$force_default = true;
	}

	// Packages archive and single
	if ( is_post_type_archive( 'cpt_packages' ) || is_singular( 'cpt_packages' ) ) {
		$force_default = true;
	}

	// Yachts archive and single
	if ( is_post_type_archive( 'cpt_yachts' ) || is_singular( 'cpt_yachts' ) ) {
		$force_default = true;
	}

	// Services archive and single
	if ( is_post_type_archive( 'bky_services' ) || is_singular( 'bky_services' ) ) {
		$force_default = true;
	}

	if ( $force_default ) {
		return 'templates/header-default';
	}

	return $template;
}
add_filter( 'yacht_rental_filter_get_template_part', 'yr_force_default_header_template' );

/**
 * Force header_position to 'default' (not 'over') on custom CPT pages.
 * 'over' makes the header position:absolute with transparent bg, which
 * causes it to be invisible when there's no hero/slider behind it.
 */
function yr_force_default_header_position( $classes ) {
	$force = false;

	if ( get_query_var( 'about_page' ) || is_singular( 'about' ) ) {
		$force = true;
	}
	if ( is_post_type_archive( 'cpt_packages' ) || is_singular( 'cpt_packages' ) ) {
		$force = true;
	}
	if ( is_post_type_archive( 'cpt_yachts' ) || is_singular( 'cpt_yachts' ) ) {
		$force = true;
	}
	if ( is_post_type_archive( 'bky_services' ) || is_singular( 'bky_services' ) ) {
		$force = true;
	}

	if ( $force ) {
		// Replace header_position_over with header_position_default
		$classes = array_map( function( $class ) {
			return $class === 'header_position_over' ? 'header_position_default' : $class;
		}, $classes );
	}

	return $classes;
}
add_filter( 'body_class', 'yr_force_default_header_position', 20 );

/**
 * Add 'expand_content' body class on services pages so the theme's own
 * rule body.body_style_wide:not(.expand_content) ... does NOT apply,
 * removing the CSS variable width constraint from div.content.
 */
add_filter( 'body_class', function( $classes ) {
	if ( is_post_type_archive( 'bky_services' ) || is_singular( 'bky_services' ) ) {
		$classes[] = 'expand_content';
	}
	return $classes;
}, 20 );

/**
 * Remove the big top padding on CPT pages.
 * The theme adds page_content_wrap_custom_header_margin class and inline
 * padding-top for the custom layout header height, but we use header-default
 * on CPT pages so this padding creates a large empty gap.
 */
function yr_remove_custom_header_margin_on_cpts() {
	$force = false;

	if ( get_query_var( 'about_page' ) || is_singular( 'about' ) ) {
		$force = true;
	}
	if ( is_post_type_archive( 'cpt_packages' ) || is_singular( 'cpt_packages' ) ) {
		$force = true;
	}
	if ( is_post_type_archive( 'cpt_yachts' ) || is_singular( 'cpt_yachts' ) ) {
		$force = true;
	}
	if ( is_post_type_archive( 'bky_services' ) || is_singular( 'bky_services' ) ) {
		$force = true;
	}

	if ( $force ) {
		echo '<style>
			.page_content_wrap.page_content_wrap_custom_header_margin {
				padding-top: 30px !important;
			}
			.page_content_wrap[style*="padding-top"] {
				padding-top: 30px !important;
			}
			.yacht-rental-full-height {
				min-height: 0 !important;
			}
		</style>';
	}


}
add_action( 'wp_head', 'yr_remove_custom_header_margin_on_cpts', 9999 );

/**
 * Fix cursor/click-area issue on services admin list screen.
 * The theme may apply transforms or z-index that shift the row-actions area.
 */
function yr_services_admin_head() {
	$screen = get_current_screen();
	if ( ! $screen || $screen->id !== 'edit-bky_services' ) return;
	echo '<style>
		/* Neutralise TRX dialog overlay CSS without touching JS */
		body.post-type-bky_services.dialog-body,
		body.post-type-bky_services.dialog-container { overflow: auto !important; }
		body.post-type-bky_services.dialog-body::before,
		body.post-type-bky_services.dialog-body::after,
		body.post-type-bky_services.dialog-container::before,
		body.post-type-bky_services.dialog-container::after { display: none !important; content: none !important; }
		body.post-type-bky_services .trx_addons_popup_overlay,
		body.post-type-bky_services .sc_layouts_popup_overlay { display: none !important; }
	</style>';
}
add_action( 'admin_head', 'yr_services_admin_head' );

// =====================================================
// ABOUT PAGE ROUTING
// =====================================================

function yr_about_flush_rewrite_rules() {
    if ( ! get_option( 'yr_about_permalinks_flushed_v3' ) ) {
        flush_rewrite_rules();
        update_option( 'yr_about_permalinks_flushed_v3', true );
    }
}
add_action( 'admin_init', 'yr_about_flush_rewrite_rules' );

function yr_about_rewrite_rules() {
    add_rewrite_rule(
        '^about/?$',
        'index.php?post_type=about&about_page=1',
        'top'
    );

    if ( function_exists( 'pll_languages_list' ) ) {
        $languages = pll_languages_list( array( 'fields' => 'slug' ) );
        $default_lang = pll_default_language( 'slug' );

        foreach ( $languages as $lang ) {
            if ( $lang === $default_lang ) {
                continue;
            }
            add_rewrite_rule(
                '^' . $lang . '/about/?$',
                'index.php?post_type=about&about_page=1&lang=' . $lang,
                'top'
            );
        }
    }
}
add_action( 'init', 'yr_about_rewrite_rules' );

function yr_about_query_vars( $vars ) {
    $vars[] = 'about_page';
    return $vars;
}
add_filter( 'query_vars', 'yr_about_query_vars' );

function yr_about_pre_get_posts( $query ) {
    if ( ! is_admin() && $query->is_main_query() && $query->get( 'about_page' ) ) {
        $query->set( 'post_type', 'about' );
        $query->set( 'posts_per_page', 1 );

        if ( function_exists( 'pll_current_language' ) ) {
            $lang = $query->get( 'lang' );
            if ( ! $lang ) {
                $lang = pll_current_language();
            }
            if ( $lang ) {
                $query->set( 'lang', $lang );
            }
        }
    }
}
add_action( 'pre_get_posts', 'yr_about_pre_get_posts' );

function yr_about_template_include( $template ) {
    if ( get_query_var( 'about_page' ) ) {
        $new_template = locate_template( array( 'single-about.php' ) );
        if ( $new_template ) {
            return $new_template;
        }
    }
    return $template;
}
add_filter( 'template_include', 'yr_about_template_include' );

// Make About page appear as singular so Rank Math outputs correct SEO meta
function yr_about_setup_singular_for_seo() {
    if ( ! get_query_var( 'about_page' ) ) {
        return;
    }

    global $wp_query, $post;

    if ( $wp_query->have_posts() ) {
        $post = $wp_query->posts[0];
        setup_postdata( $post );

        $wp_query->is_singular          = true;
        $wp_query->is_single            = true;
        $wp_query->is_archive           = false;
        $wp_query->is_post_type_archive = false;
        $wp_query->queried_object       = $post;
        $wp_query->queried_object_id    = $post->ID;
    }
}
add_action( 'wp', 'yr_about_setup_singular_for_seo', 1 );

// Fix Polylang language switcher links for About page
function yr_about_polylang_switcher_urls( $url, $slug, $locale ) {
    if ( get_query_var( 'about_page' ) ) {
        $default_lang = pll_default_language( 'slug' );

        if ( $slug === $default_lang ) {
            $url = home_url( '/about/' );
        } else {
            $url = home_url( '/' . $slug . '/about/' );
        }
    }

    return $url;
}
add_filter( 'pll_the_language_link', 'yr_about_polylang_switcher_urls', 10, 3 );

// =====================================================
// FONTS & MISC
// =====================================================

// Disable theme fonts and load Roboto
add_filter( 'yacht_rental_filter_theme_fonts_links', '__return_empty_array' );

function yacht_rental_load_roboto_font() {
    wp_enqueue_style(
        'roboto-font',
        'https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap',
        array(),
        null
    );
}
add_action( 'wp_enqueue_scripts', 'yacht_rental_load_roboto_font', 0 );

function yacht_rental_roboto_font_css() {
    echo '<style>
        body,
        h1, h2, h3, h4, h5, h6,
        p, span, a, li, td, th,
        input, textarea, button, select,
        .elementor-widget-text-editor,
        .elementor-heading-title,
        .elementor-widget-container,
        [class*="elementor-"] {
            font-family: "Roboto", sans-serif !important;
        }
    </style>';
}
add_action( 'wp_head', 'yacht_rental_roboto_font_css', 999 );

// Remove WooCommerce fonts
add_filter( 'woocommerce_register_fonts', '__return_empty_array' );

// Enqueue Success Page Styles
if ( ! function_exists( 'yacht_rental_success_page_styles' ) ) {
    function yacht_rental_success_page_styles() {
        if ( is_page_template( 'page-success.php' ) ) {
            wp_enqueue_style(
                'yacht-rental-success-page',
                get_stylesheet_directory_uri() . '/css/success-page.css',
                array(),
                '1.0.0'
            );
        }
    }
    add_action( 'wp_enqueue_scripts', 'yacht_rental_success_page_styles', 1500 );
}
