<?php
/* TI WooCommerce Wishlist support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('yacht_rental_wishlist_theme_setup9')) {
	add_action( 'after_setup_theme', 'yacht_rental_wishlist_theme_setup9', 9 );
	function yacht_rental_wishlist_theme_setup9() {
		if (is_admin()) {
			add_filter( 'yacht_rental_filter_tgmpa_required_plugins',		'yacht_rental_wishlist_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'yacht_rental_wishlist_tgmpa_required_plugins' ) ) {
	function yacht_rental_wishlist_tgmpa_required_plugins($list=array()) {
		if (yacht_rental_storage_isset('required_plugins', 'ti-woocommerce-wishlist') && yacht_rental_storage_get_array( 'required_plugins', 'ti-woocommerce-wishlist', 'install' ) !== false) {
			$list[] = array(
				'name' 		=> yacht_rental_storage_get_array('required_plugins', 'ti-woocommerce-wishlist', 'title'),
				'slug' 		=> 'ti-woocommerce-wishlist',
				'required' 	=> false
			);
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'yacht_rental_exists_wishlist' ) ) {
	function yacht_rental_exists_wishlist() {
		return function_exists('activation_tinv_wishlist');
	}
}


// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'yacht_rental_wishlist_importer_required_plugins' ) ) {
    if (is_admin()) add_filter( 'trx_addons_filter_importer_required_plugins',	'yacht_rental_wishlist_importer_required_plugins', 10, 2 );
    function yacht_rental_wishlist_importer_required_plugins($not_installed='', $list='') {
        if (strpos($list, 'ti-woocommerce-wishlist')!==false && !yacht_rental_exists_wishlist() )
            $not_installed .= '<br>' . esc_html__('WooCommerce Wishlist', 'yacht-rental');
        return $not_installed;
    }
}

// Set plugin's specific importer options
if ( !function_exists( 'yacht_rental_wishlist_importer_set_options' ) ) {
    if (is_admin()) add_filter( 'trx_addons_filter_importer_options',	'yacht_rental_wishlist_importer_set_options' );
    function yacht_rental_wishlist_importer_set_options($options=array()) {
        if ( yacht_rental_exists_wishlist() && in_array('ti-woocommerce-wishlist', $options['required_plugins']) ) {
            $options['additional_options'][] = 'tinvwl-%';
        }
        return $options;
    }
}


?>