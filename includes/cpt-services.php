<?php
/**
 * Custom Post Type: Services
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// =====================================================
// REGISTER CUSTOM POST TYPE
// =====================================================
function yr_register_services_cpt() {
	$labels = array(
		'name'                  => _x( 'Services', 'Post Type General Name', 'yacht-rental' ),
		'singular_name'         => _x( 'Service', 'Post Type Singular Name', 'yacht-rental' ),
		'menu_name'             => __( 'Services', 'yacht-rental' ),
		'name_admin_bar'        => __( 'Service', 'yacht-rental' ),
		'archives'              => __( 'Service Archives', 'yacht-rental' ),
		'all_items'             => __( 'All Services', 'yacht-rental' ),
		'add_new_item'          => __( 'Add New Service', 'yacht-rental' ),
		'add_new'               => __( 'Add New', 'yacht-rental' ),
		'new_item'              => __( 'New Service', 'yacht-rental' ),
		'edit_item'             => __( 'Edit Service', 'yacht-rental' ),
		'update_item'           => __( 'Update Service', 'yacht-rental' ),
		'view_item'             => __( 'View Service', 'yacht-rental' ),
		'view_items'            => __( 'View Services', 'yacht-rental' ),
		'search_items'          => __( 'Search Service', 'yacht-rental' ),
		'not_found'             => __( 'Not found', 'yacht-rental' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'yacht-rental' ),
		'featured_image'        => __( 'Service Image', 'yacht-rental' ),
		'set_featured_image'    => __( 'Set service image', 'yacht-rental' ),
		'remove_featured_image' => __( 'Remove service image', 'yacht-rental' ),
	);

	$args = array(
		'label'               => __( 'Service', 'yacht-rental' ),
		'description'         => __( 'Yacht rental services', 'yacht-rental' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 8,
		'menu_icon'           => 'dashicons-star-filled',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
		'show_in_rest'        => true,
		'rewrite'             => array( 'slug' => 'services', 'with_front' => false ),
	);

	register_post_type( 'bky_services', $args );
}
add_action( 'init', 'yr_register_services_cpt', 0 );

// Polylang support
add_filter( 'pll_get_post_types', 'yr_services_polylang', 10, 2 );
function yr_services_polylang( $post_types, $is_settings ) {
	$post_types['bky_services'] = 'bky_services';
	return $post_types;
}

// Completely unregister TRX Addons' cpt_services post type
add_action( 'init', 'yr_kill_trx_services', 999 );
function yr_kill_trx_services() {
	unregister_post_type( 'cpt_services' );
}

// Force flush on wp_loaded (after all CPTs registered) until confirmed
add_action( 'wp_loaded', 'yr_services_flush_rules_v4' );
function yr_services_flush_rules_v4() {
	if ( ! get_option( 'yr_services_rewrite_flushed_v4' ) ) {
		flush_rewrite_rules( true );
		update_option( 'yr_services_rewrite_flushed_v4', true );
	}
}

// =====================================================
// META BOXES
// =====================================================
add_action( 'add_meta_boxes', 'yr_add_service_meta_boxes' );
function yr_add_service_meta_boxes() {
	add_meta_box(
		'service_details',
		__( 'Service Details', 'yacht-rental' ),
		'yr_render_service_meta_box',
		'bky_services',
		'normal',
		'high'
	);
}

function yr_render_service_meta_box( $post ) {
	wp_nonce_field( 'yr_service_meta_box', 'yr_service_meta_box_nonce' );

	$head_description   = get_post_meta( $post->ID, '_service_head_description', true );
	$bottom_description = get_post_meta( $post->ID, '_service_bottom_description', true );
	$features           = get_post_meta( $post->ID, '_service_features', true );
	$contact_link       = get_post_meta( $post->ID, '_service_contact_link', true );
	$contact_btn_text   = get_post_meta( $post->ID, '_service_contact_btn_text', true );
	$service_icon       = get_post_meta( $post->ID, '_service_icon', true );
	$service_faq        = get_post_meta( $post->ID, '_service_faq', true );
	if ( ! is_array( $service_faq ) ) {
		$service_faq = array();
	}
	?>
	<style>
		.yr-service-meta label { font-weight: 600; display: block; margin-bottom: 5px; margin-top: 15px; }
		.yr-service-meta input[type="text"],
		.yr-service-meta input[type="url"],
		.yr-service-meta textarea { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
		.yr-service-meta textarea { min-height: 100px; resize: vertical; }
		.yr-faq-row { background: #f9f9f9; border: 1px solid #e0e0e0; border-radius: 6px; padding: 12px; margin-bottom: 10px; }
		.yr-faq-row input, .yr-faq-row textarea { width: 100%; margin-bottom: 6px; padding: 7px; border: 1px solid #ddd; border-radius: 4px; }
		.yr-faq-row textarea { min-height: 70px; resize: vertical; }
		.yr-faq-remove { background: #dc3232; color: #fff; border: none; padding: 5px 12px; border-radius: 4px; cursor: pointer; font-size: 12px; }
		.yr-add-faq { margin-top: 8px; }
	</style>

	<div class="yr-service-meta">

		<!-- Icon emoji -->
		<label><?php _e( 'Card Icon (emoji)', 'yacht-rental' ); ?></label>
		<input type="text" name="service_icon" value="<?php echo esc_attr( $service_icon ); ?>" placeholder="e.g. 🎵 📸 🚗 🍽️ 🌸" style="width:200px;">
		<p class="description" style="margin-top:4px;"><?php _e( 'Emoji shown on the bottom-left of the card image.', 'yacht-rental' ); ?></p>

		<!-- Head Description -->
		<label><?php _e( 'Head Description', 'yacht-rental' ); ?></label>
		<?php
		wp_editor( $head_description, 'service_head_description', array(
			'textarea_name' => 'service_head_description',
			'media_buttons' => false,
			'textarea_rows' => 5,
			'teeny'         => true,
		) );
		?>

		<!-- Features -->
		<label><?php _e( 'Features List (one per line)', 'yacht-rental' ); ?></label>
		<textarea name="service_features" placeholder="<?php esc_attr_e( "Professional DJ service (4-8 hours)\nProfessional sound equipment\n...", 'yacht-rental' ); ?>"><?php echo esc_textarea( $features ); ?></textarea>

		<!-- Contact Link -->
		<label><?php _e( 'Contact / WhatsApp Link', 'yacht-rental' ); ?></label>
		<input type="url" name="service_contact_link" value="<?php echo esc_attr( $contact_link ); ?>" placeholder="https://wa.me/994...">

		<!-- Contact Button Text -->
		<label><?php _e( 'Get In Touch Button Text', 'yacht-rental' ); ?></label>
		<input type="text" name="service_contact_btn_text" value="<?php echo esc_attr( $contact_btn_text ); ?>" placeholder="<?php esc_attr_e( 'GET IN TOUCH', 'yacht-rental' ); ?>">

		<!-- Bottom Description -->
		<label><?php _e( 'Bottom Description', 'yacht-rental' ); ?></label>
		<?php
		wp_editor( $bottom_description, 'service_bottom_description', array(
			'textarea_name' => 'service_bottom_description',
			'media_buttons' => false,
			'textarea_rows' => 6,
			'teeny'         => true,
		) );
		?>

		<!-- FAQ -->
		<label><?php _e( 'FAQ', 'yacht-rental' ); ?></label>
		<div id="yr-service-faq-container">
			<?php foreach ( $service_faq as $i => $faq ) : ?>
			<div class="yr-faq-row">
				<input type="text" name="service_faq[<?php echo $i; ?>][question]"
					value="<?php echo esc_attr( $faq['question'] ?? '' ); ?>"
					placeholder="<?php esc_attr_e( 'Question', 'yacht-rental' ); ?>">
				<textarea name="service_faq[<?php echo $i; ?>][answer]"
					placeholder="<?php esc_attr_e( 'Answer', 'yacht-rental' ); ?>"><?php echo esc_textarea( $faq['answer'] ?? '' ); ?></textarea>
				<button type="button" class="yr-faq-remove"><?php _e( 'Remove', 'yacht-rental' ); ?></button>
			</div>
			<?php endforeach; ?>
		</div>
		<button type="button" class="button yr-add-faq" id="yr-add-service-faq">+ <?php _e( 'Add FAQ', 'yacht-rental' ); ?></button>
	</div>

	<script>
	(function(){
		var container = document.getElementById('yr-service-faq-container');
		var count = <?php echo count( $service_faq ); ?>;

		document.getElementById('yr-add-service-faq').addEventListener('click', function() {
			var row = document.createElement('div');
			row.className = 'yr-faq-row';
			row.innerHTML =
				'<input type="text" name="service_faq[' + count + '][question]" placeholder="Question">' +
				'<textarea name="service_faq[' + count + '][answer]" placeholder="Answer"></textarea>' +
				'<button type="button" class="yr-faq-remove">Remove</button>';
			container.appendChild(row);
			count++;
		});

		container.addEventListener('click', function(e) {
			if ( e.target.classList.contains('yr-faq-remove') ) {
				e.target.closest('.yr-faq-row').remove();
			}
		});
	})();
	</script>
	<?php
}

// =====================================================
// SAVE META BOX
// =====================================================
add_action( 'save_post_bky_services', 'yr_save_service_meta' );
function yr_save_service_meta( $post_id ) {
	if ( ! isset( $_POST['yr_service_meta_box_nonce'] ) ||
		 ! wp_verify_nonce( $_POST['yr_service_meta_box_nonce'], 'yr_service_meta_box' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	$text_fields = array(
		'service_icon'             => '_service_icon',
		'service_contact_link'     => '_service_contact_link',
		'service_contact_btn_text' => '_service_contact_btn_text',
	);
	foreach ( $text_fields as $post_key => $meta_key ) {
		if ( isset( $_POST[ $post_key ] ) ) {
			update_post_meta( $post_id, $meta_key, sanitize_text_field( $_POST[ $post_key ] ) );
		}
	}

	// Features: use sanitize_textarea_field to preserve newlines
	if ( isset( $_POST['service_features'] ) ) {
		update_post_meta( $post_id, '_service_features', sanitize_textarea_field( $_POST['service_features'] ) );
	}

	// wp_editor fields (allow HTML)
	if ( isset( $_POST['service_head_description'] ) ) {
		update_post_meta( $post_id, '_service_head_description', wp_kses_post( $_POST['service_head_description'] ) );
	}
	if ( isset( $_POST['service_bottom_description'] ) ) {
		update_post_meta( $post_id, '_service_bottom_description', wp_kses_post( $_POST['service_bottom_description'] ) );
	}

	// FAQ
	$faq = array();
	if ( isset( $_POST['service_faq'] ) && is_array( $_POST['service_faq'] ) ) {
		foreach ( $_POST['service_faq'] as $item ) {
			$q = sanitize_text_field( $item['question'] ?? '' );
			$a = sanitize_textarea_field( $item['answer'] ?? '' );
			if ( $q ) {
				$faq[] = array( 'question' => $q, 'answer' => $a );
			}
		}
	}
	update_post_meta( $post_id, '_service_faq', $faq );
}

// =====================================================
// ADMIN COLUMNS
// =====================================================
add_filter( 'manage_bky_services_posts_columns', 'yr_service_columns' );
function yr_service_columns( $columns ) {
	$new = array();
	foreach ( $columns as $key => $val ) {
		$new[ $key ] = $val;
		if ( $key === 'title' ) {
			$new['service_icon'] = __( 'Icon', 'yacht-rental' );
		}
	}
	return $new;
}

add_action( 'manage_bky_services_posts_custom_column', 'yr_service_column_content', 10, 2 );
function yr_service_column_content( $column, $post_id ) {
	if ( $column === 'service_icon' ) {
		$icon = get_post_meta( $post_id, '_service_icon', true );
		echo $icon ? '<span style="font-size:24px;">' . esc_html( $icon ) . '</span>' : '—';
	}
}

// =====================================================
// ENQUEUE STYLES
// =====================================================
add_action( 'wp_enqueue_scripts', 'yr_enqueue_services_assets' );
function yr_enqueue_services_assets() {
	if ( is_post_type_archive( 'bky_services' ) || is_singular( 'bky_services' ) ) {
		wp_enqueue_style(
			'yr-services',
			get_stylesheet_directory_uri() . '/css/services.css',
			array(),
			'1.0.0'
		);
	}
}
