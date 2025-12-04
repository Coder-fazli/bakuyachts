<?php
/* WPC Smart Quick View for WooCommerce support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('yacht_rental_quick_view_theme_setup9')) {
	add_action( 'after_setup_theme', 'yacht_rental_quick_view_theme_setup9', 9 );
	function yacht_rental_quick_view_theme_setup9() {
		if (yacht_rental_exists_quick_view()) {
			add_action( 'wp_enqueue_scripts', 'yacht_rental_quick_view_frontend_scripts', 1100 );
			add_filter( 'yacht_rental_filter_merge_styles', 'yacht_rental_quick_view_merge_styles' );
		}
		if (is_admin()) {
			add_filter( 'yacht_rental_filter_tgmpa_required_plugins',		'yacht_rental_quick_view_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'yacht_rental_quick_view_tgmpa_required_plugins' ) ) {
	function yacht_rental_quick_view_tgmpa_required_plugins($list=array()) {
		if (yacht_rental_storage_isset( 'required_plugins', 'woocommerce' ) && yacht_rental_storage_get_array( 'required_plugins', 'woocommerce', 'install' ) !== false &&
			yacht_rental_storage_isset('required_plugins', 'woo-smart-quick-view') && yacht_rental_storage_get_array( 'required_plugins', 'woo-smart-quick-view', 'install' ) !== false) {
			$list[] = array(
				'name' 		=> yacht_rental_storage_get_array('required_plugins', 'woo-smart-quick-view', 'title'),
				'slug' 		=> 'woo-smart-quick-view',
				'required' 	=> false
			);
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'yacht_rental_exists_quick_view' ) ) {
	function yacht_rental_exists_quick_view() {
		return function_exists('woosq_init');
	}
}

// Enqueue custom scripts
if ( ! function_exists( 'yacht_rental_quick_view_frontend_scripts' ) ) {
	function yacht_rental_quick_view_frontend_scripts() {
		if ( yacht_rental_is_on( yacht_rental_get_theme_option( 'debug_mode' ) ) ) {
			$yacht_rental_url = yacht_rental_get_file_url( 'plugins/woo-smart-quick-view/woo-smart-quick-view.css' );
			if ( '' != $yacht_rental_url ) {
				wp_enqueue_style( 'yacht-rental-woo-smart-quick-view', $yacht_rental_url, array(), null );
			}
		}
	}
}

// Merge custom styles
if ( ! function_exists( 'yacht_rental_quick_view_merge_styles' ) ) {
	function yacht_rental_quick_view_merge_styles( $list ) {
		$list['plugins/woo-smart-quick-view/woo-smart-quick-view.css'] = true;
		return $list;
	}
}

// Add plugin-specific colors and fonts to the custom CSS
if ( yacht_rental_exists_quick_view() ) {
	require_once yacht_rental_get_file_dir( 'plugins/woo-smart-quick-view/woo-smart-quick-view-style.php' );
}


// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'yacht_rental_quick_view_importer_required_plugins' ) ) {
    if (is_admin()) add_filter( 'trx_addons_filter_importer_required_plugins',	'yacht_rental_quick_view_importer_required_plugins', 10, 2 );
    function yacht_rental_quick_view_importer_required_plugins($not_installed='', $list='') {
        if (strpos($list, 'woo-smart-quick-view')!==false && !yacht_rental_exists_quick_view() )
            $not_installed .= '<br>' . esc_html__('WPC Smart Quick View for WooCommerce', 'yacht-rental');
        return $not_installed;
    }
}

// Set plugin's specific importer options
if ( !function_exists( 'yacht_rental_quick_view_importer_set_options' ) ) {
    if (is_admin()) add_filter( 'trx_addons_filter_importer_options',	'yacht_rental_quick_view_importer_set_options' );
    function yacht_rental_quick_view_importer_set_options($options=array()) {
        if ( yacht_rental_exists_quick_view() && in_array('woo-smart-quick-view', $options['required_plugins']) ) {
            $options['additional_options'][] = 'woosq_%';
        }
        return $options;
    }
}