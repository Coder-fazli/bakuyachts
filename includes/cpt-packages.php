<?php
/**
 * Custom Post Type: Packages
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0
 */

// Register Custom Post Type: Packages
function yr_register_packages_cpt() {
	$labels = array(
		'name'                  => _x( 'Packages', 'Post Type General Name', 'yacht-rental' ),
		'singular_name'         => _x( 'Package', 'Post Type Singular Name', 'yacht-rental' ),
		'menu_name'             => __( 'Packages', 'yacht-rental' ),
		'name_admin_bar'        => __( 'Package', 'yacht-rental' ),
		'archives'              => __( 'Package Archives', 'yacht-rental' ),
		'attributes'            => __( 'Package Attributes', 'yacht-rental' ),
		'parent_item_colon'     => __( 'Parent Package:', 'yacht-rental' ),
		'all_items'             => __( 'All Packages', 'yacht-rental' ),
		'add_new_item'          => __( 'Add New Package', 'yacht-rental' ),
		'add_new'               => __( 'Add New', 'yacht-rental' ),
		'new_item'              => __( 'New Package', 'yacht-rental' ),
		'edit_item'             => __( 'Edit Package', 'yacht-rental' ),
		'update_item'           => __( 'Update Package', 'yacht-rental' ),
		'view_item'             => __( 'View Package', 'yacht-rental' ),
		'view_items'            => __( 'View Packages', 'yacht-rental' ),
		'search_items'          => __( 'Search Package', 'yacht-rental' ),
		'not_found'             => __( 'Not found', 'yacht-rental' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'yacht-rental' ),
		'featured_image'        => __( 'Package Image', 'yacht-rental' ),
		'set_featured_image'    => __( 'Set package image', 'yacht-rental' ),
		'remove_featured_image' => __( 'Remove package image', 'yacht-rental' ),
		'use_featured_image'    => __( 'Use as package image', 'yacht-rental' ),
		'insert_into_item'      => __( 'Insert into package', 'yacht-rental' ),
		'uploaded_to_this_item' => __( 'Uploaded to this package', 'yacht-rental' ),
		'items_list'            => __( 'Packages list', 'yacht-rental' ),
		'items_list_navigation' => __( 'Packages list navigation', 'yacht-rental' ),
		'filter_items_list'     => __( 'Filter packages list', 'yacht-rental' ),
	);

	$args = array(
		'label'                 => __( 'Package', 'yacht-rental' ),
		'description'           => __( 'Yacht rental packages', 'yacht-rental' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 6,
		'menu_icon'             => 'dashicons-tickets-alt',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
		'rewrite'               => array( 'slug' => 'packages', 'with_front' => false ),
	);

	register_post_type( 'cpt_packages', $args );
}
add_action( 'init', 'yr_register_packages_cpt', 0 );

// Add custom meta boxes for package fields
function yr_add_package_meta_boxes() {
	add_meta_box(
		'package_details',
		__( 'Package Details', 'yacht-rental' ),
		'yr_render_package_meta_box',
		'cpt_packages',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'yr_add_package_meta_boxes' );

// Render the package meta box
function yr_render_package_meta_box( $post ) {
	// Add nonce for security
	wp_nonce_field( 'yr_package_meta_box', 'yr_package_meta_box_nonce' );

	// Get existing values
	$package_title = get_post_meta( $post->ID, '_package_title', true );
	$package_features = get_post_meta( $post->ID, '_package_features', true );
	$whatsapp_number = get_post_meta( $post->ID, '_whatsapp_number', true );
	$button_link = get_post_meta( $post->ID, '_button_link', true );

	?>
	<table class="form-table">
		<tr>
			<th><label for="package_title"><?php _e( 'Package Title', 'yacht-rental' ); ?></label></th>
			<td>
				<input type="text" id="package_title" name="package_title" value="<?php echo esc_attr( $package_title ); ?>" class="large-text" placeholder="<?php esc_attr_e( 'e.g., Choose Your Birthday Yacht Rental Dubai Package', 'yacht-rental' ); ?>" />
				<p class="description"><?php _e( 'This is the secondary title shown in the package content section (not the main page title H1)', 'yacht-rental' ); ?></p>
			</td>
		</tr>
		<tr>
			<th><label for="package_features"><?php _e( 'Package Features', 'yacht-rental' ); ?></label></th>
			<td>
				<textarea id="package_features" name="package_features" rows="15" class="large-text"><?php echo esc_textarea( $package_features ); ?></textarea>
				<p class="description"><?php _e( 'Enter each feature on a new line. Green checkmarks will be added automatically.', 'yacht-rental' ); ?></p>
				<p class="description"><strong><?php _e( 'Example:', 'yacht-rental' ); ?></strong><br/>
					Included in a package<br/>
					3hr+ luxury yacht cruise<br/>
					Yacht beautifully decorated with balloons<br/>
					Birthday cake with a personalized message<br/>
					Red carpet welcome & welcome drinks<br/>
					Water, ice and soft drinks<br/>
					Add-ons<br/>
					Fine-dinning catering from 5-star restaurants<br/>
					DJ, premium sound system, and disco lighting onboard<br/>
					Photographer, videographer, drone shooting
				</p>
			</td>
		</tr>
		<tr>
			<th><label for="whatsapp_number"><?php _e( 'WhatsApp Number', 'yacht-rental' ); ?></label></th>
			<td>
				<input type="text" id="whatsapp_number" name="whatsapp_number" value="<?php echo esc_attr( $whatsapp_number ); ?>" class="regular-text" placeholder="<?php esc_attr_e( 'e.g., +971501234567', 'yacht-rental' ); ?>" />
				<p class="description"><?php _e( 'Enter WhatsApp number with country code (e.g., +971501234567). This will be used for the "GET IN TOUCH" button.', 'yacht-rental' ); ?></p>
			</td>
		</tr>
		<tr>
			<th><label for="button_link"><?php _e( 'Custom Button Link (Optional)', 'yacht-rental' ); ?></label></th>
			<td>
				<input type="url" id="button_link" name="button_link" value="<?php echo esc_url( $button_link ); ?>" class="large-text" placeholder="<?php esc_attr_e( 'https://example.com/contact', 'yacht-rental' ); ?>" />
				<p class="description"><?php _e( 'If you want to use a custom link instead of WhatsApp, enter it here. Leave empty to use WhatsApp number.', 'yacht-rental' ); ?></p>
			</td>
		</tr>
	</table>
	<?php
}

// Save package meta box data
function yr_save_package_meta_box_data( $post_id ) {
	// Check if nonce is set
	if ( ! isset( $_POST['yr_package_meta_box_nonce'] ) ) {
		return;
	}

	// Verify nonce
	if ( ! wp_verify_nonce( $_POST['yr_package_meta_box_nonce'], 'yr_package_meta_box' ) ) {
		return;
	}

	// Check if autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check permissions
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// Save package title
	if ( isset( $_POST['package_title'] ) ) {
		update_post_meta( $post_id, '_package_title', sanitize_text_field( $_POST['package_title'] ) );
	}

	// Save package features
	if ( isset( $_POST['package_features'] ) ) {
		update_post_meta( $post_id, '_package_features', sanitize_textarea_field( $_POST['package_features'] ) );
	}

	// Save WhatsApp number
	if ( isset( $_POST['whatsapp_number'] ) ) {
		update_post_meta( $post_id, '_whatsapp_number', sanitize_text_field( $_POST['whatsapp_number'] ) );
	}

	// Save button link
	if ( isset( $_POST['button_link'] ) ) {
		update_post_meta( $post_id, '_button_link', esc_url_raw( $_POST['button_link'] ) );
	}
}
add_action( 'save_post_cpt_packages', 'yr_save_package_meta_box_data' );

// Flush rewrite rules on activation
function yr_packages_rewrite_flush() {
	// Register CPT first
	yr_register_packages_cpt();

	// Then flush
	flush_rewrite_rules();

	// Mark as flushed to prevent repeated flushes
	if ( ! get_option( 'yr_packages_permalinks_flushed' ) ) {
		update_option( 'yr_packages_permalinks_flushed', true );
	}
}
register_activation_hook( __FILE__, 'yr_packages_rewrite_flush' );

// Flush on theme switch
add_action( 'after_switch_theme', 'yr_packages_rewrite_flush' );

// Check and flush permalinks if needed (run once)
function yr_packages_check_flush() {
	if ( ! get_option( 'yr_packages_permalinks_flushed' ) ) {
		yr_packages_rewrite_flush();
	}
}
add_action( 'admin_init', 'yr_packages_check_flush' );

// Add Polylang support - Register CPT for translation
function yr_packages_polylang_register_cpt( $post_types, $is_settings ) {
	$post_types['cpt_packages'] = 'cpt_packages';
	return $post_types;
}
add_filter( 'pll_get_post_types', 'yr_packages_polylang_register_cpt', 10, 2 );
