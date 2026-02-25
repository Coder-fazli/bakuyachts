<?php
/**
 * Custom Post Type: Slider
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0
 */

// Register Custom Post Type: Slider
function yr_register_slider_cpt() {
	$labels = array(
		'name'                  => _x( 'Slides', 'Post Type General Name', 'yacht-rental' ),
		'singular_name'         => _x( 'Slide', 'Post Type Singular Name', 'yacht-rental' ),
		'menu_name'             => __( 'Slider', 'yacht-rental' ),
		'name_admin_bar'        => __( 'Slide', 'yacht-rental' ),
		'archives'              => __( 'Slide Archives', 'yacht-rental' ),
		'attributes'            => __( 'Slide Attributes', 'yacht-rental' ),
		'parent_item_colon'     => __( 'Parent Slide:', 'yacht-rental' ),
		'all_items'             => __( 'All Slides', 'yacht-rental' ),
		'add_new_item'          => __( 'Add New Slide', 'yacht-rental' ),
		'add_new'               => __( 'Add New', 'yacht-rental' ),
		'new_item'              => __( 'New Slide', 'yacht-rental' ),
		'edit_item'             => __( 'Edit Slide', 'yacht-rental' ),
		'update_item'           => __( 'Update Slide', 'yacht-rental' ),
		'view_item'             => __( 'View Slide', 'yacht-rental' ),
		'view_items'            => __( 'View Slides', 'yacht-rental' ),
		'search_items'          => __( 'Search Slide', 'yacht-rental' ),
		'not_found'             => __( 'Not found', 'yacht-rental' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'yacht-rental' ),
		'featured_image'        => __( 'Slide Image', 'yacht-rental' ),
		'set_featured_image'    => __( 'Set slide image', 'yacht-rental' ),
		'remove_featured_image' => __( 'Remove slide image', 'yacht-rental' ),
		'use_featured_image'    => __( 'Use as slide image', 'yacht-rental' ),
		'insert_into_item'      => __( 'Insert into slide', 'yacht-rental' ),
		'uploaded_to_this_item' => __( 'Uploaded to this slide', 'yacht-rental' ),
		'items_list'            => __( 'Slides list', 'yacht-rental' ),
		'items_list_navigation' => __( 'Slides list navigation', 'yacht-rental' ),
		'filter_items_list'     => __( 'Filter slides list', 'yacht-rental' ),
	);

	$args = array(
		'label'                 => __( 'Slide', 'yacht-rental' ),
		'description'           => __( 'Slides for the about page slider', 'yacht-rental' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-images-alt2',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => false,
		'capability_type'       => 'page',
	);

	register_post_type( 'cpt_slider', $args );
}
add_action( 'init', 'yr_register_slider_cpt', 0 );

// Add meta boxes for slider
function yr_slider_meta_box() {
	add_meta_box(
		'yr_slider_details',
		__( 'Slide Details', 'yacht-rental' ),
		'yr_slider_meta_box_callback',
		'cpt_slider',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'yr_slider_meta_box' );

function yr_slider_meta_box_callback( $post ) {
	wp_nonce_field( 'yr_slider_meta_box', 'yr_slider_meta_box_nonce' );

	$heading = get_post_meta( $post->ID, '_yr_slider_heading', true );
	$subheading = get_post_meta( $post->ID, '_yr_slider_subheading', true );
	?>
	<table class="form-table">
		<tr>
			<th><label for="yr_slider_heading"><?php _e( 'Heading', 'yacht-rental' ); ?></label></th>
			<td><input type="text" id="yr_slider_heading" name="yr_slider_heading" value="<?php echo esc_attr( $heading ); ?>" class="regular-text" /></td>
		</tr>
		<tr>
			<th><label for="yr_slider_subheading"><?php _e( 'Subheading', 'yacht-rental' ); ?></label></th>
			<td><input type="text" id="yr_slider_subheading" name="yr_slider_subheading" value="<?php echo esc_attr( $subheading ); ?>" class="regular-text" /></td>
		</tr>
	</table>
	<?php
}

function yr_save_slider_meta( $post_id ) {
	if ( ! isset( $_POST['yr_slider_meta_box_nonce'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( $_POST['yr_slider_meta_box_nonce'], 'yr_slider_meta_box' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( 'cpt_slider' !== get_post_type( $post_id ) ) {
		return;
	}

	if ( isset( $_POST['yr_slider_heading'] ) ) {
		update_post_meta( $post_id, '_yr_slider_heading', sanitize_text_field( $_POST['yr_slider_heading'] ) );
	}
	if ( isset( $_POST['yr_slider_subheading'] ) ) {
		update_post_meta( $post_id, '_yr_slider_subheading', sanitize_text_field( $_POST['yr_slider_subheading'] ) );
	}
}
add_action( 'save_post', 'yr_save_slider_meta' );
