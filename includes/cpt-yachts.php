<?php
/**
 * Custom Post Type: Yachts
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0
 */

// Register Custom Post Type: Yachts
function yr_register_yachts_cpt() {
	$labels = array(
		'name'                  => _x( 'Yachts', 'Post Type General Name', 'yacht-rental' ),
		'singular_name'         => _x( 'Yacht', 'Post Type Singular Name', 'yacht-rental' ),
		'menu_name'             => __( 'Yachts', 'yacht-rental' ),
		'name_admin_bar'        => __( 'Yacht', 'yacht-rental' ),
		'archives'              => __( 'Yacht Archives', 'yacht-rental' ),
		'attributes'            => __( 'Yacht Attributes', 'yacht-rental' ),
		'parent_item_colon'     => __( 'Parent Yacht:', 'yacht-rental' ),
		'all_items'             => __( 'All Yachts', 'yacht-rental' ),
		'add_new_item'          => __( 'Add New Yacht', 'yacht-rental' ),
		'add_new'               => __( 'Add New', 'yacht-rental' ),
		'new_item'              => __( 'New Yacht', 'yacht-rental' ),
		'edit_item'             => __( 'Edit Yacht', 'yacht-rental' ),
		'update_item'           => __( 'Update Yacht', 'yacht-rental' ),
		'view_item'             => __( 'View Yacht', 'yacht-rental' ),
		'view_items'            => __( 'View Yachts', 'yacht-rental' ),
		'search_items'          => __( 'Search Yacht', 'yacht-rental' ),
		'not_found'             => __( 'Not found', 'yacht-rental' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'yacht-rental' ),
		'featured_image'        => __( 'Yacht Image', 'yacht-rental' ),
		'set_featured_image'    => __( 'Set yacht image', 'yacht-rental' ),
		'remove_featured_image' => __( 'Remove yacht image', 'yacht-rental' ),
		'use_featured_image'    => __( 'Use as yacht image', 'yacht-rental' ),
		'insert_into_item'      => __( 'Insert into yacht', 'yacht-rental' ),
		'uploaded_to_this_item' => __( 'Uploaded to this yacht', 'yacht-rental' ),
		'items_list'            => __( 'Yachts list', 'yacht-rental' ),
		'items_list_navigation' => __( 'Yachts list navigation', 'yacht-rental' ),
		'filter_items_list'     => __( 'Filter yachts list', 'yacht-rental' ),
	);

	$args = array(
		'label'                 => __( 'Yacht', 'yacht-rental' ),
		'description'           => __( 'Yachts for rent', 'yacht-rental' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes' ),
		'taxonomies'            => array( 'yr_yacht_category' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-palmtree',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => 'yachts',
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
	);

	register_post_type( 'cpt_yachts', $args );
}
add_action( 'init', 'yr_register_yachts_cpt', 0 );

// Register Custom Taxonomy: Yacht Category
function yr_register_yacht_category_taxonomy() {
	$labels = array(
		'name'                       => _x( 'Yacht Categories', 'Taxonomy General Name', 'yacht-rental' ),
		'singular_name'              => _x( 'Yacht Category', 'Taxonomy Singular Name', 'yacht-rental' ),
		'menu_name'                  => __( 'Categories', 'yacht-rental' ),
		'all_items'                  => __( 'All Categories', 'yacht-rental' ),
		'parent_item'                => __( 'Parent Category', 'yacht-rental' ),
		'parent_item_colon'          => __( 'Parent Category:', 'yacht-rental' ),
		'new_item_name'              => __( 'New Category Name', 'yacht-rental' ),
		'add_new_item'               => __( 'Add New Category', 'yacht-rental' ),
		'edit_item'                  => __( 'Edit Category', 'yacht-rental' ),
		'update_item'                => __( 'Update Category', 'yacht-rental' ),
		'view_item'                  => __( 'View Category', 'yacht-rental' ),
		'separate_items_with_commas' => __( 'Separate categories with commas', 'yacht-rental' ),
		'add_or_remove_items'        => __( 'Add or remove categories', 'yacht-rental' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'yacht-rental' ),
		'popular_items'              => __( 'Popular Categories', 'yacht-rental' ),
		'search_items'               => __( 'Search Categories', 'yacht-rental' ),
		'not_found'                  => __( 'Not Found', 'yacht-rental' ),
		'no_terms'                   => __( 'No categories', 'yacht-rental' ),
		'items_list'                 => __( 'Categories list', 'yacht-rental' ),
		'items_list_navigation'      => __( 'Categories list navigation', 'yacht-rental' ),
	);

	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'show_in_rest'               => true,
	);

	register_taxonomy( 'yr_yacht_category', array( 'cpt_yachts' ), $args );
}
add_action( 'init', 'yr_register_yacht_category_taxonomy', 0 );

// Add Polylang support
function yr_yachts_polylang_support() {
	if ( function_exists( 'pll_register_string' ) ) {
		// Register CPT and Taxonomy for Polylang
		add_filter( 'pll_get_post_types', function( $post_types ) {
			$post_types['cpt_yachts'] = 'cpt_yachts';
			return $post_types;
		}, 10, 1 );

		add_filter( 'pll_get_taxonomies', function( $taxonomies ) {
			$taxonomies['yr_yacht_category'] = 'yr_yacht_category';
			return $taxonomies;
		}, 10, 1 );
	}
}
add_action( 'init', 'yr_yachts_polylang_support', 20 );

// Add meta box for yacht details
function yr_yacht_meta_box() {
	add_meta_box(
		'yr_yacht_details',
		__( 'Yacht Details', 'yacht-rental' ),
		'yr_yacht_meta_box_callback',
		'cpt_yachts',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'yr_yacht_meta_box' );

function yr_yacht_meta_box_callback( $post ) {
	wp_nonce_field( 'yr_yacht_meta_box', 'yr_yacht_meta_box_nonce' );

	$price = get_post_meta( $post->ID, '_yr_yacht_price', true );
	$length = get_post_meta( $post->ID, '_yr_yacht_length', true );
	$cabins = get_post_meta( $post->ID, '_yr_yacht_cabins', true );
	$guests = get_post_meta( $post->ID, '_yr_yacht_guests', true );
	$badge = get_post_meta( $post->ID, '_yr_yacht_badge', true );
	?>
	<table class="form-table">
		<tr>
			<th><label for="yr_yacht_price"><?php _e( 'Price (per hour)', 'yacht-rental' ); ?></label></th>
			<td><input type="text" id="yr_yacht_price" name="yr_yacht_price" value="<?php echo esc_attr( $price ); ?>" class="regular-text" placeholder="AED 1,300/hr" /></td>
		</tr>
		<tr>
			<th><label for="yr_yacht_length"><?php _e( 'Length (ft)', 'yacht-rental' ); ?></label></th>
			<td><input type="text" id="yr_yacht_length" name="yr_yacht_length" value="<?php echo esc_attr( $length ); ?>" class="regular-text" placeholder="60 ft" /></td>
		</tr>
		<tr>
			<th><label for="yr_yacht_cabins"><?php _e( 'Cabins', 'yacht-rental' ); ?></label></th>
			<td><input type="text" id="yr_yacht_cabins" name="yr_yacht_cabins" value="<?php echo esc_attr( $cabins ); ?>" class="regular-text" placeholder="3" /></td>
		</tr>
		<tr>
			<th><label for="yr_yacht_guests"><?php _e( 'Max Guests', 'yacht-rental' ); ?></label></th>
			<td><input type="text" id="yr_yacht_guests" name="yr_yacht_guests" value="<?php echo esc_attr( $guests ); ?>" class="regular-text" placeholder="15" /></td>
		</tr>
		<tr>
			<th><label for="yr_yacht_badge"><?php _e( 'Badge (optional)', 'yacht-rental' ); ?></label></th>
			<td>
				<input type="text" id="yr_yacht_badge" name="yr_yacht_badge" value="<?php echo esc_attr( $badge ); ?>" class="regular-text" placeholder="SPECIAL OFFER, BEST SELLER" />
				<p class="description"><?php _e( 'Example: SPECIAL OFFER, BEST SELLER, NEW', 'yacht-rental' ); ?></p>
			</td>
		</tr>
	</table>
	<?php
}

function yr_save_yacht_meta( $post_id ) {
	if ( ! isset( $_POST['yr_yacht_meta_box_nonce'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( $_POST['yr_yacht_meta_box_nonce'], 'yr_yacht_meta_box' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['yr_yacht_price'] ) ) {
		update_post_meta( $post_id, '_yr_yacht_price', sanitize_text_field( $_POST['yr_yacht_price'] ) );
	}
	if ( isset( $_POST['yr_yacht_length'] ) ) {
		update_post_meta( $post_id, '_yr_yacht_length', sanitize_text_field( $_POST['yr_yacht_length'] ) );
	}
	if ( isset( $_POST['yr_yacht_cabins'] ) ) {
		update_post_meta( $post_id, '_yr_yacht_cabins', sanitize_text_field( $_POST['yr_yacht_cabins'] ) );
	}
	if ( isset( $_POST['yr_yacht_guests'] ) ) {
		update_post_meta( $post_id, '_yr_yacht_guests', sanitize_text_field( $_POST['yr_yacht_guests'] ) );
	}
	if ( isset( $_POST['yr_yacht_badge'] ) ) {
		update_post_meta( $post_id, '_yr_yacht_badge', sanitize_text_field( $_POST['yr_yacht_badge'] ) );
	}
}
add_action( 'save_post', 'yr_save_yacht_meta' );

// Create demo yachts (run once)
function yr_create_demo_yachts() {
	// Check if demo posts already created
	if ( get_option( 'yr_demo_yachts_created' ) ) {
		return;
	}

	$demo_yachts = array(
		array(
			'title' => 'Azimut Grande "KAMI"',
			'price' => 'AED 800/hr',
			'length' => '55 ft',
			'cabins' => '3',
			'guests' => '15',
			'badge' => 'SPECIAL OFFER',
			'content' => 'Luxury Azimut yacht for an unforgettable experience. Perfect for family trips and celebrations.',
		),
		array(
			'title' => 'Sky 92ft "LUNA"',
			'price' => 'AED 850/hr',
			'length' => '92 ft',
			'cabins' => '2',
			'guests' => '17',
			'badge' => 'BEST SELLER',
			'content' => 'Spacious and elegant yacht with modern amenities. Ideal for corporate events and parties.',
		),
		array(
			'title' => 'Sky 62ft "BELLA"',
			'price' => 'AED 1,300/hr',
			'length' => '62 ft',
			'cabins' => '3',
			'guests' => '25',
			'badge' => '',
			'content' => 'Modern yacht with excellent performance. Great for day trips and water sports.',
		),
		array(
			'title' => 'Monte Carlo 60ft "NOVA"',
			'price' => 'AED 1,600/hr',
			'length' => '60 ft',
			'cabins' => '3',
			'guests' => '15',
			'badge' => 'BEST SELLER',
			'content' => 'Premium Monte Carlo yacht offering ultimate comfort and luxury on the water.',
		),
		array(
			'title' => 'Sea Ray "PEARL"',
			'price' => 'AED 950/hr',
			'length' => '58 ft',
			'cabins' => '2',
			'guests' => '12',
			'badge' => '',
			'content' => 'Classic Sea Ray yacht perfect for intimate gatherings and romantic cruises.',
		),
	);

	foreach ( $demo_yachts as $yacht_data ) {
		$post_id = wp_insert_post( array(
			'post_title'   => $yacht_data['title'],
			'post_content' => $yacht_data['content'],
			'post_status'  => 'publish',
			'post_type'    => 'cpt_yachts',
		) );

		if ( $post_id && ! is_wp_error( $post_id ) ) {
			update_post_meta( $post_id, '_yr_yacht_price', $yacht_data['price'] );
			update_post_meta( $post_id, '_yr_yacht_length', $yacht_data['length'] );
			update_post_meta( $post_id, '_yr_yacht_cabins', $yacht_data['cabins'] );
			update_post_meta( $post_id, '_yr_yacht_guests', $yacht_data['guests'] );

			if ( ! empty( $yacht_data['badge'] ) ) {
				update_post_meta( $post_id, '_yr_yacht_badge', $yacht_data['badge'] );
			}

			// Try to set placeholder image from media library
			$placeholder_image_id = yr_get_placeholder_image();
			if ( $placeholder_image_id ) {
				set_post_thumbnail( $post_id, $placeholder_image_id );
			}
		}
	}

	// Mark as created
	update_option( 'yr_demo_yachts_created', true );
}
add_action( 'init', 'yr_create_demo_yachts' );

// Helper: Get or create placeholder image
function yr_get_placeholder_image() {
	// Check if placeholder already exists
	$args = array(
		'post_type'      => 'attachment',
		'posts_per_page' => 1,
		'post_status'    => 'inherit',
		'meta_query'     => array(
			array(
				'key'   => '_yr_yacht_placeholder',
				'value' => '1',
			),
		),
	);

	$attachments = get_posts( $args );
	if ( ! empty( $attachments ) ) {
		return $attachments[0]->ID;
	}

	// Try to find any yacht/boat image in media library
	$args = array(
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'posts_per_page' => 1,
		'post_status'    => 'inherit',
	);

	$attachments = get_posts( $args );
	if ( ! empty( $attachments ) ) {
		$image_id = $attachments[0]->ID;
		update_post_meta( $image_id, '_yr_yacht_placeholder', '1' );
		return $image_id;
	}

	return false;
}
