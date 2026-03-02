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

// Add explicit rewrite rules for /services/ on every request.
// When extra_rules_top is non-empty, WordPress regenerates all rewrite
// rules on the same request — no manual flush needed.
add_action( 'init', 'yr_services_rewrite_rules', 1 );
function yr_services_rewrite_rules() {
	add_rewrite_rule( '^services/?$', 'index.php?post_type=bky_services', 'top' );
	add_rewrite_rule( '^services/([^/]+)/?$', 'index.php?bky_services=$matches[1]', 'top' );
}

// =====================================================
// ARCHIVE SEO SETTINGS PAGE
// =====================================================
add_action( 'admin_menu', 'yr_services_archive_seo_menu' );
function yr_services_archive_seo_menu() {
	add_submenu_page(
		'edit.php?post_type=bky_services',
		__( 'Archive SEO', 'yacht-rental' ),
		__( 'Archive SEO', 'yacht-rental' ),
		'manage_options',
		'yr-services-archive-seo',
		'yr_services_archive_seo_page'
	);
}

function yr_services_archive_seo_page() {
	$languages = array( 'en' => 'English' );
	if ( function_exists( 'pll_languages_list' ) ) {
		$pll_languages = pll_languages_list( array( 'fields' => 'slug' ) );
		$languages     = array();
		foreach ( $pll_languages as $lang ) {
			$lang_name = strtoupper( $lang );
			if ( function_exists( 'PLL' ) && isset( PLL()->model ) ) {
				$lang_obj = PLL()->model->get_language( $lang );
				if ( $lang_obj ) $lang_name = $lang_obj->name;
			}
			$languages[ $lang ] = $lang_name;
		}
	}

	if ( isset( $_POST['yr_services_seo_save'] ) && check_admin_referer( 'yr_services_seo_nonce' ) ) {
		foreach ( $languages as $lang_code => $lang_name ) {
			update_option( "yr_services_archive_meta_title_{$lang_code}", sanitize_text_field( $_POST["yr_services_meta_title_{$lang_code}"] ?? '' ) );
			update_option( "yr_services_archive_meta_desc_{$lang_code}", sanitize_textarea_field( $_POST["yr_services_meta_desc_{$lang_code}"] ?? '' ) );
		}
		echo '<div class="notice notice-success is-dismissible"><p>' . __( 'SEO settings saved.', 'yacht-rental' ) . '</p></div>';
	}
	?>
	<div class="wrap">
		<h1><?php _e( 'Services Archive — SEO Settings', 'yacht-rental' ); ?></h1>
		<p class="description"><?php _e( 'Set the meta title and meta description for the Services archive page. These override Rank Math for each language.', 'yacht-rental' ); ?></p>
		<form method="post">
			<?php wp_nonce_field( 'yr_services_seo_nonce' ); ?>
			<?php foreach ( $languages as $lang_code => $lang_name ) : ?>
				<h2 style="margin-top:25px;padding-top:15px;border-top:1px solid #ccc;"><?php echo esc_html( $lang_name ); ?> (<?php echo strtoupper( esc_html( $lang_code ) ); ?>)</h2>
				<table class="form-table">
					<tr>
						<th><label><?php _e( 'Meta Title', 'yacht-rental' ); ?></label></th>
						<td><input type="text" name="yr_services_meta_title_<?php echo esc_attr( $lang_code ); ?>" value="<?php echo esc_attr( get_option( "yr_services_archive_meta_title_{$lang_code}", '' ) ); ?>" class="large-text" placeholder="<?php esc_attr_e( 'Services | Baku Yachts', 'yacht-rental' ); ?>" /></td>
					</tr>
					<tr>
						<th><label><?php _e( 'Meta Description', 'yacht-rental' ); ?></label></th>
						<td><textarea name="yr_services_meta_desc_<?php echo esc_attr( $lang_code ); ?>" class="large-text" rows="3" placeholder="<?php esc_attr_e( 'Explore our yacht rental services in Baku...', 'yacht-rental' ); ?>"><?php echo esc_textarea( get_option( "yr_services_archive_meta_desc_{$lang_code}", '' ) ); ?></textarea></td>
					</tr>
				</table>
			<?php endforeach; ?>
			<p class="submit"><input type="submit" name="yr_services_seo_save" class="button button-primary" value="<?php _e( 'Save SEO Settings', 'yacht-rental' ); ?>" /></p>
		</form>
	</div>
	<?php
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
