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
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
		'rewrite'               => array( 'slug' => 'yachts', 'with_front' => false ),
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

// Flush rewrite rules on activation
function yr_yachts_rewrite_flush() {
	// Register CPT and taxonomy first
	yr_register_yachts_cpt();
	yr_register_yacht_category_taxonomy();

	// Then flush
	flush_rewrite_rules();

	// Mark as flushed to prevent repeated flushes
	if ( ! get_option( 'yr_yachts_permalinks_flushed' ) ) {
		update_option( 'yr_yachts_permalinks_flushed', true );
	}
}
register_activation_hook( __FILE__, 'yr_yachts_rewrite_flush' );

// Flush on theme switch
add_action( 'after_switch_theme', 'yr_yachts_rewrite_flush' );

// Check and flush permalinks if needed (run once)
function yr_yachts_check_flush() {
	// Delete the option to force flush after code changes
	$version = get_option( 'yr_yachts_version', '1.0' );
	if ( version_compare( $version, '1.3', '<' ) ) {
		delete_option( 'yr_yachts_permalinks_flushed' );
		delete_option( 'yr_yachts_languages_fixed' );
		delete_option( 'yr_demo_yachts_created' ); // Force demo recreate with new fields
		update_option( 'yr_yachts_version', '1.3' );
	}

	if ( ! get_option( 'yr_yachts_permalinks_flushed' ) ) {
		yr_yachts_rewrite_flush();
	}
}
add_action( 'admin_init', 'yr_yachts_check_flush' );

// Add Polylang support - Register CPT for translation
function yr_yachts_polylang_register_cpt( $post_types, $is_settings ) {
	$post_types['cpt_yachts'] = 'cpt_yachts';
	return $post_types;
}
add_filter( 'pll_get_post_types', 'yr_yachts_polylang_register_cpt', 10, 2 );

// Add Polylang support - Register Taxonomy for translation
function yr_yachts_polylang_register_tax( $taxonomies, $is_settings ) {
	$taxonomies['yr_yacht_category'] = 'yr_yacht_category';
	return $taxonomies;
}
add_filter( 'pll_get_taxonomies', 'yr_yachts_polylang_register_tax', 10, 2 );

// Add meta boxes for yacht
function yr_yacht_meta_box() {
	// Basic Details
	add_meta_box(
		'yr_yacht_details',
		__( 'Yacht Details', 'yacht-rental' ),
		'yr_yacht_meta_box_callback',
		'cpt_yachts',
		'normal',
		'high'
	);

	// Gallery Slider
	add_meta_box(
		'yr_yacht_gallery',
		__( 'Gallery Slider', 'yacht-rental' ),
		'yr_yacht_gallery_callback',
		'cpt_yachts',
		'normal',
		'default'
	);

	// Pricing (Old/New Price)
	add_meta_box(
		'yr_yacht_pricing',
		__( 'Pricing', 'yacht-rental' ),
		'yr_yacht_pricing_callback',
		'cpt_yachts',
		'normal',
		'default'
	);

	// Contact (WhatsApp, Phone)
	add_meta_box(
		'yr_yacht_contact',
		__( 'Contact Information', 'yacht-rental' ),
		'yr_yacht_contact_callback',
		'cpt_yachts',
		'normal',
		'default'
	);

	// Key Features
	add_meta_box(
		'yr_yacht_features',
		__( 'Key Features', 'yacht-rental' ),
		'yr_yacht_features_callback',
		'cpt_yachts',
		'normal',
		'default'
	);

	// We Also Offer
	add_meta_box(
		'yr_yacht_offers',
		__( 'We Also Offer', 'yacht-rental' ),
		'yr_yacht_offers_callback',
		'cpt_yachts',
		'normal',
		'default'
	);

	// FAQ
	add_meta_box(
		'yr_yacht_faq',
		__( 'FAQ', 'yacht-rental' ),
		'yr_yacht_faq_callback',
		'cpt_yachts',
		'normal',
		'default'
	);
}
add_action( 'add_meta_boxes', 'yr_yacht_meta_box' );

// Enqueue scripts for admin
function yr_yacht_admin_scripts( $hook ) {
	global $post;
	if ( ( 'post.php' === $hook || 'post-new.php' === $hook ) && isset( $post ) && 'cpt_yachts' === $post->post_type ) {
		wp_enqueue_media();
		wp_enqueue_script( 'jquery-ui-sortable' );
	}
}
add_action( 'admin_enqueue_scripts', 'yr_yacht_admin_scripts' );

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

// Gallery Slider Meta Box - SIMPLIFIED VERSION
function yr_yacht_gallery_callback( $post ) {
	wp_nonce_field( 'yr_yacht_gallery_save', 'yr_yacht_gallery_nonce' );

	$gallery_ids = get_post_meta( $post->ID, '_yr_yacht_gallery_ids', true );
	if ( ! is_array( $gallery_ids ) ) {
		$gallery_ids = array();
	}
	?>
	<div class="yr-gallery-wrap">
		<ul class="yr-gallery-images" id="yr_gallery_images">
			<?php foreach ( $gallery_ids as $image_id ) : ?>
				<li class="yr-image" data-attachment-id="<?php echo esc_attr( $image_id ); ?>">
					<?php echo wp_get_attachment_image( $image_id, 'thumbnail' ); ?>
					<a href="#" class="yr-remove-image">Remove</a>
				</li>
			<?php endforeach; ?>
		</ul>
		<input type="hidden" id="yr_gallery_ids" name="yr_gallery_ids" value="<?php echo esc_attr( implode( ',', $gallery_ids ) ); ?>" />
		<p>
			<a href="#" class="yr-upload-gallery button"><?php _e( 'Add Images', 'yacht-rental' ); ?></a>
		</p>
	</div>

	<style>
		.yr-gallery-images { list-style: none; margin: 0; padding: 0; display: flex; flex-wrap: wrap; gap: 10px; }
		.yr-gallery-images .yr-image { position: relative; width: 100px; height: 100px; border: 2px solid #ddd; border-radius: 4px; overflow: hidden; }
		.yr-gallery-images .yr-image img { width: 100%; height: 100%; object-fit: cover; }
		.yr-gallery-images .yr-image .yr-remove-image { position: absolute; top: 5px; right: 5px; background: #dc3232; color: white; text-decoration: none; padding: 2px 6px; border-radius: 3px; font-size: 11px; }
		.yr-gallery-images .yr-image .yr-remove-image:hover { background: #a00; }
	</style>

	<script>
	jQuery(document).ready(function($) {
		var fileFrame;

		$('.yr-upload-gallery').on('click', function(e) {
			e.preventDefault();

			if (fileFrame) {
				fileFrame.open();
				return;
			}

			fileFrame = wp.media.frames.fileFrame = wp.media({
				title: 'Select Images',
				button: { text: 'Use Images' },
				multiple: true
			});

			fileFrame.on('select', function() {
				var attachments = fileFrame.state().get('selection').toJSON();
				var ids = $('#yr_gallery_ids').val() ? $('#yr_gallery_ids').val().split(',') : [];

				attachments.forEach(function(attachment) {
					if (ids.indexOf(attachment.id.toString()) === -1) {
						ids.push(attachment.id);
						var imgUrl = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
						$('#yr_gallery_images').append(
							'<li class="yr-image" data-attachment-id="' + attachment.id + '">' +
							'<img src="' + imgUrl + '" />' +
							'<a href="#" class="yr-remove-image">Remove</a>' +
							'</li>'
						);
					}
				});

				$('#yr_gallery_ids').val(ids.join(','));
			});

			fileFrame.open();
		});

		$('#yr_gallery_images').on('click', '.yr-remove-image', function(e) {
			e.preventDefault();
			var li = $(this).closest('.yr-image');
			var id = li.data('attachment-id');
			li.remove();

			var ids = $('#yr_gallery_ids').val().split(',').filter(function(val) {
				return val != id && val != '';
			});
			$('#yr_gallery_ids').val(ids.join(','));
		});

		$('#yr_gallery_images').sortable({
			update: function() {
				var ids = [];
				$('#yr_gallery_images .yr-image').each(function() {
					ids.push($(this).data('attachment-id'));
				});
				$('#yr_gallery_ids').val(ids.join(','));
			}
		});
	});
	</script>
	<?php
}

// Pricing Meta Box
function yr_yacht_pricing_callback( $post ) {
	wp_nonce_field( 'yr_yacht_pricing_nonce', 'yr_yacht_pricing_nonce' );
	$old_price = get_post_meta( $post->ID, '_yr_yacht_old_price', true );
	$new_price = get_post_meta( $post->ID, '_yr_yacht_new_price', true );
	$price_label = get_post_meta( $post->ID, '_yr_yacht_price_label', true );
	?>
	<table class="form-table">
		<tr>
			<th><label for="yr_yacht_old_price"><?php _e( 'Old Price', 'yacht-rental' ); ?></label></th>
			<td><input type="text" id="yr_yacht_old_price" name="yr_yacht_old_price" value="<?php echo esc_attr( $old_price ); ?>" class="regular-text" placeholder="AED 1,500" /></td>
		</tr>
		<tr>
			<th><label for="yr_yacht_new_price"><?php _e( 'New Price', 'yacht-rental' ); ?></label></th>
			<td><input type="text" id="yr_yacht_new_price" name="yr_yacht_new_price" value="<?php echo esc_attr( $new_price ); ?>" class="regular-text" placeholder="AED 850" /></td>
		</tr>
		<tr>
			<th><label for="yr_yacht_price_label"><?php _e( 'Price Label', 'yacht-rental' ); ?></label></th>
			<td><input type="text" id="yr_yacht_price_label" name="yr_yacht_price_label" value="<?php echo esc_attr( $price_label ); ?>" class="regular-text" placeholder="per hour" /></td>
		</tr>
	</table>
	<?php
}

// Contact Info Meta Box
function yr_yacht_contact_callback( $post ) {
	wp_nonce_field( 'yr_yacht_contact_nonce', 'yr_yacht_contact_nonce' );
	$whatsapp = get_post_meta( $post->ID, '_yr_yacht_whatsapp', true );
	$phone = get_post_meta( $post->ID, '_yr_yacht_phone', true );
	?>
	<table class="form-table">
		<tr>
			<th><label for="yr_yacht_whatsapp"><?php _e( 'WhatsApp Number', 'yacht-rental' ); ?></label></th>
			<td><input type="text" id="yr_yacht_whatsapp" name="yr_yacht_whatsapp" value="<?php echo esc_attr( $whatsapp ); ?>" class="regular-text" placeholder="+971501234567" /></td>
		</tr>
		<tr>
			<th><label for="yr_yacht_phone"><?php _e( 'Phone Number', 'yacht-rental' ); ?></label></th>
			<td><input type="text" id="yr_yacht_phone" name="yr_yacht_phone" value="<?php echo esc_attr( $phone ); ?>" class="regular-text" placeholder="+971501234567" /></td>
		</tr>
	</table>
	<?php
}

// Key Features Meta Box
function yr_yacht_features_callback( $post ) {
	wp_nonce_field( 'yr_yacht_features_nonce', 'yr_yacht_features_nonce' );
	$features = get_post_meta( $post->ID, '_yr_yacht_features', true );
	$features = ! empty( $features ) ? $features : array( '' );
	?>
	<div class="yr-repeater" id="yr_features_repeater">
		<?php foreach ( $features as $index => $feature ) : ?>
			<div class="yr-repeater-item">
				<input type="text" name="yr_yacht_features[]" value="<?php echo esc_attr( $feature ); ?>" class="large-text" placeholder="<?php _e( 'Feature text', 'yacht-rental' ); ?>" />
				<button type="button" class="button yr-remove-item"><?php _e( 'Remove', 'yacht-rental' ); ?></button>
			</div>
		<?php endforeach; ?>
	</div>
	<button type="button" class="button button-primary yr-add-item" data-target="yr_features_repeater"><?php _e( 'Add Feature', 'yacht-rental' ); ?></button>
	<style>.yr-repeater-item {display: flex; gap: 10px; margin-bottom: 10px;}</style>
	<script>
	jQuery(document).ready(function($) {
		$('.yr-add-item').on('click', function() {
			var target = $('#' + $(this).data('target'));
			var item = target.find('.yr-repeater-item:first').clone();
			item.find('input').val('');
			target.append(item);
		});
		$(document).on('click', '.yr-remove-item', function() {
			if ($('.yr-repeater-item').length > 1) $(this).parent().remove();
		});
	});
	</script>
	<?php
}

// We Also Offer Meta Box
function yr_yacht_offers_callback( $post ) {
	wp_nonce_field( 'yr_yacht_offers_nonce', 'yr_yacht_offers_nonce' );
	$offers = get_post_meta( $post->ID, '_yr_yacht_offers', true );
	$offers = ! empty( $offers ) ? $offers : array( '' );
	?>
	<div class="yr-repeater" id="yr_offers_repeater">
		<?php foreach ( $offers as $index => $offer ) : ?>
			<div class="yr-repeater-item">
				<input type="text" name="yr_yacht_offers[]" value="<?php echo esc_attr( $offer ); ?>" class="large-text" placeholder="<?php _e( 'Offer text', 'yacht-rental' ); ?>" />
				<button type="button" class="button yr-remove-item"><?php _e( 'Remove', 'yacht-rental' ); ?></button>
			</div>
		<?php endforeach; ?>
	</div>
	<button type="button" class="button button-primary yr-add-item" data-target="yr_offers_repeater"><?php _e( 'Add Offer', 'yacht-rental' ); ?></button>
	<?php
}

// FAQ Meta Box
function yr_yacht_faq_callback( $post ) {
	wp_nonce_field( 'yr_yacht_faq_nonce', 'yr_yacht_faq_nonce' );
	$faq = get_post_meta( $post->ID, '_yr_yacht_faq', true );
	$faq = ! empty( $faq ) ? $faq : array( array( 'question' => '', 'answer' => '' ) );
	?>
	<div class="yr-faq-repeater" id="yr_faq_repeater">
		<?php foreach ( $faq as $index => $item ) : ?>
			<div class="yr-faq-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; border-radius: 4px;">
				<p><strong><?php _e( 'Question', 'yacht-rental' ); ?>:</strong></p>
				<input type="text" name="yr_yacht_faq[<?php echo $index; ?>][question]" value="<?php echo esc_attr( $item['question'] ); ?>" class="large-text" placeholder="<?php _e( 'Enter question', 'yacht-rental' ); ?>" />
				<p><strong><?php _e( 'Answer', 'yacht-rental' ); ?>:</strong></p>
				<textarea name="yr_yacht_faq[<?php echo $index; ?>][answer]" class="large-text" rows="3" placeholder="<?php _e( 'Enter answer', 'yacht-rental' ); ?>"><?php echo esc_textarea( $item['answer'] ); ?></textarea>
				<button type="button" class="button yr-remove-faq" style="margin-top: 10px;"><?php _e( 'Remove FAQ', 'yacht-rental' ); ?></button>
			</div>
		<?php endforeach; ?>
	</div>
	<button type="button" class="button button-primary" id="yr_add_faq"><?php _e( 'Add FAQ', 'yacht-rental' ); ?></button>
	<script>
	jQuery(document).ready(function($) {
		var faqIndex = <?php echo count( $faq ); ?>;
		$('#yr_add_faq').on('click', function() {
			var html = '<div class="yr-faq-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; border-radius: 4px;">';
			html += '<p><strong>Question:</strong></p>';
			html += '<input type="text" name="yr_yacht_faq[' + faqIndex + '][question]" class="large-text" placeholder="Enter question" />';
			html += '<p><strong>Answer:</strong></p>';
			html += '<textarea name="yr_yacht_faq[' + faqIndex + '][answer]" class="large-text" rows="3" placeholder="Enter answer"></textarea>';
			html += '<button type="button" class="button yr-remove-faq" style="margin-top: 10px;">Remove FAQ</button></div>';
			$('#yr_faq_repeater').append(html);
			faqIndex++;
		});
		$(document).on('click', '.yr-remove-faq', function() {
			if ($('.yr-faq-item').length > 1) $(this).parent().remove();
		});
	});
	</script>
	<?php
}

function yr_save_yacht_meta( $post_id ) {
	// Check if any of our nonces are set
	$has_nonce = isset( $_POST['yr_yacht_meta_box_nonce'] ) ||
	             isset( $_POST['yr_yacht_gallery_nonce'] ) ||
	             isset( $_POST['yr_yacht_pricing_nonce'] ) ||
	             isset( $_POST['yr_yacht_contact_nonce'] ) ||
	             isset( $_POST['yr_yacht_features_nonce'] ) ||
	             isset( $_POST['yr_yacht_offers_nonce'] ) ||
	             isset( $_POST['yr_yacht_faq_nonce'] );

	if ( ! $has_nonce ) {
		return;
	}

	// Verify at least one nonce
	$verified = false;
	if ( isset( $_POST['yr_yacht_meta_box_nonce'] ) && wp_verify_nonce( $_POST['yr_yacht_meta_box_nonce'], 'yr_yacht_meta_box' ) ) {
		$verified = true;
	}
	if ( isset( $_POST['yr_yacht_gallery_nonce'] ) && wp_verify_nonce( $_POST['yr_yacht_gallery_nonce'], 'yr_yacht_gallery_save' ) ) {
		$verified = true;
	}
	if ( isset( $_POST['yr_yacht_pricing_nonce'] ) && wp_verify_nonce( $_POST['yr_yacht_pricing_nonce'], 'yr_yacht_pricing_nonce' ) ) {
		$verified = true;
	}
	if ( isset( $_POST['yr_yacht_contact_nonce'] ) && wp_verify_nonce( $_POST['yr_yacht_contact_nonce'], 'yr_yacht_contact_nonce' ) ) {
		$verified = true;
	}
	if ( isset( $_POST['yr_yacht_features_nonce'] ) && wp_verify_nonce( $_POST['yr_yacht_features_nonce'], 'yr_yacht_features_nonce' ) ) {
		$verified = true;
	}
	if ( isset( $_POST['yr_yacht_offers_nonce'] ) && wp_verify_nonce( $_POST['yr_yacht_offers_nonce'], 'yr_yacht_offers_nonce' ) ) {
		$verified = true;
	}
	if ( isset( $_POST['yr_yacht_faq_nonce'] ) && wp_verify_nonce( $_POST['yr_yacht_faq_nonce'], 'yr_yacht_faq_nonce' ) ) {
		$verified = true;
	}

	if ( ! $verified ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// Make sure this is a yacht post
	if ( 'cpt_yachts' !== get_post_type( $post_id ) ) {
		return;
	}

	// Debug: Log save attempt
	error_log( 'YR Save Meta: Starting save for post ID ' . $post_id );

	// Basic Details
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

	// Gallery - SIMPLE ARRAY SAVE
	if ( isset( $_POST['yr_gallery_ids'] ) && ! empty( $_POST['yr_gallery_ids'] ) ) {
		$ids_string = sanitize_text_field( $_POST['yr_gallery_ids'] );
		$ids_array = array_filter( array_map( 'intval', explode( ',', $ids_string ) ) );
		update_post_meta( $post_id, '_yr_yacht_gallery_ids', $ids_array );
	} else {
		delete_post_meta( $post_id, '_yr_yacht_gallery_ids' );
	}

	// Pricing
	if ( isset( $_POST['yr_yacht_old_price'] ) ) {
		update_post_meta( $post_id, '_yr_yacht_old_price', sanitize_text_field( $_POST['yr_yacht_old_price'] ) );
	}
	if ( isset( $_POST['yr_yacht_new_price'] ) ) {
		update_post_meta( $post_id, '_yr_yacht_new_price', sanitize_text_field( $_POST['yr_yacht_new_price'] ) );
	}
	if ( isset( $_POST['yr_yacht_price_label'] ) ) {
		update_post_meta( $post_id, '_yr_yacht_price_label', sanitize_text_field( $_POST['yr_yacht_price_label'] ) );
	}

	// Contact
	if ( isset( $_POST['yr_yacht_whatsapp'] ) ) {
		update_post_meta( $post_id, '_yr_yacht_whatsapp', sanitize_text_field( $_POST['yr_yacht_whatsapp'] ) );
	}
	if ( isset( $_POST['yr_yacht_phone'] ) ) {
		update_post_meta( $post_id, '_yr_yacht_phone', sanitize_text_field( $_POST['yr_yacht_phone'] ) );
	}

	// Features
	if ( isset( $_POST['yr_yacht_features'] ) ) {
		$features = array_map( 'sanitize_text_field', $_POST['yr_yacht_features'] );
		update_post_meta( $post_id, '_yr_yacht_features', $features );
	}

	// Offers
	if ( isset( $_POST['yr_yacht_offers'] ) ) {
		$offers = array_map( 'sanitize_text_field', $_POST['yr_yacht_offers'] );
		update_post_meta( $post_id, '_yr_yacht_offers', $offers );
	}

	// FAQ
	if ( isset( $_POST['yr_yacht_faq'] ) ) {
		$faq = array();
		foreach ( $_POST['yr_yacht_faq'] as $item ) {
			if ( ! empty( $item['question'] ) || ! empty( $item['answer'] ) ) {
				$faq[] = array(
					'question' => sanitize_text_field( $item['question'] ),
					'answer'   => sanitize_textarea_field( $item['answer'] ),
				);
			}
		}
		update_post_meta( $post_id, '_yr_yacht_faq', $faq );
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

			// Add demo data for new meta boxes (only for first yacht)
			if ( $yacht_data['title'] === 'Sky 92ft "LUNA"' ) {
				// Pricing
				update_post_meta( $post_id, '_yr_yacht_old_price', 'AED 1,500' );
				update_post_meta( $post_id, '_yr_yacht_new_price', 'AED 850' );
				update_post_meta( $post_id, '_yr_yacht_price_label', 'per hour' );

				// Contact
				update_post_meta( $post_id, '_yr_yacht_whatsapp', '+971501234567' );
				update_post_meta( $post_id, '_yr_yacht_phone', '+971501234567' );

				// Key Features
				$features = array(
					'Price starts from AED 1,500/hr',
					'Brand: Sky 52 LUNA',
					'Guests: 15',
					'Vessel Size: 48 FT',
					'Staff: 1 Captain, 2 Crew',
					'Interior: 2 cabins, washroom, kitchen, spacious saloon, dining area',
					'Exterior: deck area with sittings, lounge, and BBQ setup',
					'Ideal for: Family Gatherings, Sightseeing, and Birthday Parties',
				);
				update_post_meta( $post_id, '_yr_yacht_features', $features );

				// We Also Offer
				$offers = array(
					'Unlimited FREE chilled water supply.',
					'Luxurious glassware and dinnerware.',
					'Live BBQ Station (you can bring your own meat or cook your catch)',
					'Alcoholic beverages are allowed on board, but we do not serve them.',
					'Food: Appetizer, Main Course, and Dessert (*as add-on)',
					'Themed yacht decor (*as add-on)',
					'Fishing equipment and water sports equipment (*as add-on)',
				);
				update_post_meta( $post_id, '_yr_yacht_offers', $offers );

				// FAQ
				$faq = array(
					array(
						'question' => 'How many people can the yacht accommodate?',
						'answer'   => 'The Sky 52ft LUNA yacht can comfortably accommodate up to 15 guests. This makes it perfect for family gatherings, birthday parties, and corporate events.',
					),
					array(
						'question' => 'What is included in the rental price?',
						'answer'   => 'The rental includes the yacht with experienced captain and crew, unlimited chilled water, luxurious glassware and dinnerware, and basic amenities. Additional services like catering, decorations, and water sports can be added for an extra fee.',
					),
					array(
						'question' => 'Can we bring our own food and drinks?',
						'answer'   => 'Yes! You can bring your own food and beverages. The yacht has a BBQ station available, and you\'re welcome to bring your own meat or cook your catch. Alcoholic beverages are allowed on board, though we don\'t serve them.',
					),
				);
				update_post_meta( $post_id, '_yr_yacht_faq', $faq );
			}

			// Set Polylang language (default language)
			if ( function_exists( 'pll_set_post_language' ) && function_exists( 'pll_default_language' ) ) {
				$default_lang = pll_default_language();
				pll_set_post_language( $post_id, $default_lang );
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

// Fix existing yachts without language (run once)
function yr_fix_yachts_languages() {
	// Check if already fixed
	if ( get_option( 'yr_yachts_languages_fixed' ) ) {
		return;
	}

	// Only run if Polylang is active
	if ( ! function_exists( 'pll_set_post_language' ) || ! function_exists( 'pll_default_language' ) ) {
		return;
	}

	$default_lang = pll_default_language();

	// Get all yachts
	$yachts = get_posts( array(
		'post_type'      => 'cpt_yachts',
		'posts_per_page' => -1,
		'post_status'    => 'any',
	) );

	foreach ( $yachts as $yacht ) {
		// Check if yacht has no language assigned
		$current_lang = pll_get_post_language( $yacht->ID );
		if ( empty( $current_lang ) ) {
			// Assign default language
			pll_set_post_language( $yacht->ID, $default_lang );
		}
	}

	// Mark as fixed
	update_option( 'yr_yachts_languages_fixed', true );
}
add_action( 'admin_init', 'yr_fix_yachts_languages' );

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

/**
 * Yacht Cards Grid Shortcode
 *
 * Usage examples:
 * [yacht_cards]                                    - Show all yachts (current language)
 * [yacht_cards limit="6"]                          - Show 6 yachts
 * [yacht_cards limit="3" badge="BEST SELLER"]      - Show 3 yachts with BEST SELLER badge
 * [yacht_cards columns="4"]                        - Show in 4 columns
 * [yacht_cards orderby="title" order="ASC"]        - Order by title ascending
 * [yacht_cards ids="123,456,789"]                  - Show specific yachts by ID
 * [yacht_cards lang="az"]                          - Show yachts in Azerbaijani language
 * [yacht_cards lang="ru"]                          - Show yachts in Russian language
 * [yacht_cards lang="en"]                          - Show yachts in English language
 * [yacht_cards lang="all"]                         - Show yachts from all languages
 */
function yr_yacht_cards_shortcode( $atts ) {
	$atts = shortcode_atts( array(
		'limit'   => -1,          // Number of yachts to show (-1 = all)
		'columns' => 3,           // Number of columns (1, 2, 3, 4)
		'orderby' => 'date',      // Order by: date, title, menu_order, rand
		'order'   => 'DESC',      // ASC or DESC
		'badge'   => '',          // Filter by badge (e.g., 'BEST SELLER')
		'ids'     => '',          // Comma-separated yacht IDs to show
		'lang'    => '',          // Language code: az, ru, en, or 'all' for all languages (default: current language)
	), $atts, 'yacht_cards' );

	// Query arguments
	$query_args = array(
		'post_type'      => 'cpt_yachts',
		'posts_per_page' => intval( $atts['limit'] ),
		'orderby'        => sanitize_text_field( $atts['orderby'] ),
		'order'          => sanitize_text_field( $atts['order'] ),
		'post_status'    => 'publish',
	);

	// Polylang language filter
	if ( function_exists( 'pll_current_language' ) ) {
		$lang_code = ! empty( $atts['lang'] ) ? sanitize_text_field( $atts['lang'] ) : '';

		if ( $lang_code === 'all' ) {
			// Show yachts from all languages - disable Polylang filter
			$query_args['lang'] = '';
		} elseif ( ! empty( $lang_code ) && in_array( $lang_code, array( 'az', 'ru', 'en' ) ) ) {
			// Show yachts from specific language
			$query_args['lang'] = $lang_code;
		} else {
			// Default: show yachts from current language
			$query_args['lang'] = pll_current_language();
		}
	}

	// Filter by specific IDs
	if ( ! empty( $atts['ids'] ) ) {
		$ids = array_map( 'intval', explode( ',', $atts['ids'] ) );
		$query_args['post__in'] = $ids;
		$query_args['orderby'] = 'post__in';
	}

	// Filter by badge
	if ( ! empty( $atts['badge'] ) ) {
		$query_args['meta_query'] = array(
			array(
				'key'   => '_yr_yacht_badge',
				'value' => sanitize_text_field( $atts['badge'] ),
			),
		);
	}

	$yachts = new WP_Query( $query_args );

	if ( ! $yachts->have_posts() ) {
		return '<p>' . __( 'No yachts found.', 'yacht-rental' ) . '</p>';
	}

	// Start output buffering
	ob_start();

	// Include the same styles from archive template
	?>
	<style>
	.yr-shortcode-wrapper {
	  padding: 40px 0;
	  background: #ffffff;
	}
	.yr-shortcode-container {
	  max-width: 1400px;
	  margin: 0 auto;
	  padding: 0 20px;
	}
	.yr-yacht-grid {
	  display: grid;
	  grid-template-columns: repeat(<?php echo intval( $atts['columns'] ); ?>, 1fr);
	  gap: 30px;
	  margin-top: 40px;
	}
	@media (max-width: 1024px) {
	  .yr-yacht-grid {
	    grid-template-columns: repeat(2, 1fr);
	  }
	}
	@media (max-width: 768px) {
	  .yr-yacht-grid {
	    grid-template-columns: 1fr;
	    gap: 20px;
	  }
	}
	.bky-yacht-card {
	  background: #ffffff;
	  border-radius: 20px;
	  overflow: hidden;
	  box-shadow: 0 4px 20px rgba(0,0,0,0.08);
	  transition: all 0.3s ease;
	  display: flex;
	  flex-direction: column;
	  height: 100%;
	}
	.bky-yacht-card:hover {
	  transform: translateY(-8px);
	  box-shadow: 0 12px 40px rgba(0,0,0,0.12);
	}
	.bky-yacht-image {
	  position: relative;
	  width: 100%;
	  height: 280px;
	  overflow: hidden;
	}
	.bky-yacht-image img {
	  width: 100%;
	  height: 100%;
	  object-fit: cover;
	  transition: transform 0.5s ease;
	}
	.bky-yacht-card:hover .bky-yacht-image img {
	  transform: scale(1.05);
	}
	.bky-yacht-badge {
	  position: absolute;
	  top: 20px;
	  left: 20px;
	  background: #FF6B6B;
	  color: white;
	  padding: 8px 20px;
	  border-radius: 25px;
	  font-size: 12px;
	  font-weight: 700;
	  letter-spacing: 0.5px;
	  text-transform: uppercase;
	  z-index: 2;
	}
	.bky-yacht-content {
	  padding: 25px;
	  flex: 1;
	  display: flex;
	  flex-direction: column;
	}
	.bky-yacht-title {
	  margin-bottom: 15px;
	}
	.bky-yacht-title h3 {
	  font-size: 22px;
	  font-weight: 600;
	  color: #1a1a1a;
	  margin: 0;
	  line-height: 1.3;
	}
	.bky-yacht-title h3 a {
	  color: #1a1a1a;
	  text-decoration: none;
	  transition: color 0.3s ease;
	}
	.bky-yacht-title h3 a:hover {
	  color: #C89D4F;
	}
	.bky-yacht-features {
	  display: flex;
	  gap: 20px;
	  margin-bottom: 20px;
	  flex-wrap: wrap;
	}
	.bky-feature-item {
	  display: flex;
	  align-items: center;
	  gap: 8px;
	  font-size: 14px;
	  color: #666;
	}
	.bky-feature-item svg {
	  width: 18px;
	  height: 18px;
	  fill: #C89D4F;
	  flex-shrink: 0;
	}
	.bky-yacht-description {
	  color: #666;
	  font-size: 14px;
	  line-height: 1.6;
	  margin-bottom: 25px;
	  flex: 1;
	}
	.bky-yacht-actions {
	  display: flex;
	  gap: 12px;
	  margin-top: auto;
	}
	.bky-yacht-btn {
	  flex: 1;
	  padding: 14px 24px;
	  border-radius: 30px;
	  font-weight: 600;
	  font-size: 14px;
	  text-decoration: none;
	  text-align: center;
	  transition: all 0.3s ease;
	  border: none;
	  cursor: pointer;
	  display: flex;
	  align-items: center;
	  justify-content: center;
	  gap: 8px;
	}
	.bky-yacht-btn-whatsapp {
	  background: #25D366;
	  color: white;
	}
	.bky-yacht-btn-whatsapp:hover {
	  background: #1da851;
	  transform: translateY(-2px);
	}
	.bky-yacht-btn-view {
	  background: #C89D4F;
	  color: white;
	}
	.bky-yacht-btn-view:hover {
	  background: #b38a3f;
	  transform: translateY(-2px);
	}
	</style>

	<div class="yr-shortcode-wrapper">
		<div class="yr-shortcode-container">
			<div class="yr-yacht-grid">
				<?php
				while ( $yachts->have_posts() ) : $yachts->the_post();
					$price  = get_post_meta( get_the_ID(), '_yr_yacht_price', true );
					$length = get_post_meta( get_the_ID(), '_yr_yacht_length', true );
					$cabins = get_post_meta( get_the_ID(), '_yr_yacht_cabins', true );
					$guests = get_post_meta( get_the_ID(), '_yr_yacht_guests', true );
					$badge  = get_post_meta( get_the_ID(), '_yr_yacht_badge', true );
					$whatsapp = get_post_meta( get_the_ID(), '_yr_yacht_whatsapp', true );
					if ( empty( $whatsapp ) ) {
						$whatsapp = '+971501234567'; // Default WhatsApp
					}
					?>
					<div class="bky-yacht-card">
						<div class="bky-yacht-image">
							<?php if ( has_post_thumbnail() ) : ?>
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail( 'large' ); ?>
								</a>
							<?php endif; ?>
							<?php if ( $badge ) : ?>
								<span class="bky-yacht-badge"><?php echo esc_html( $badge ); ?></span>
							<?php endif; ?>
						</div>

						<div class="bky-yacht-content">
							<div class="bky-yacht-title">
								<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							</div>

							<div class="bky-yacht-features">
								<?php if ( $length ) : ?>
									<div class="bky-feature-item">
										<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
										<span><?php echo esc_html( $length ); ?></span>
									</div>
								<?php endif; ?>
								<?php if ( $cabins ) : ?>
									<div class="bky-feature-item">
										<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M7 13c1.66 0 3-1.34 3-3S8.66 7 7 7s-3 1.34-3 3 1.34 3 3 3zm12-6h-8v7H3V7H1v10h22V7h-4z"/></svg>
										<span><?php echo esc_html( $cabins . ' ' . __( 'cabins', 'yacht-rental' ) ); ?></span>
									</div>
								<?php endif; ?>
								<?php if ( $guests ) : ?>
									<div class="bky-feature-item">
										<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
										<span><?php echo esc_html( $guests . ' ' . __( 'Guests', 'yacht-rental' ) ); ?></span>
									</div>
								<?php endif; ?>
							</div>

							<?php if ( has_excerpt() ) : ?>
								<div class="bky-yacht-description">
									<?php echo wp_trim_words( get_the_excerpt(), 20 ); ?>
								</div>
							<?php endif; ?>

							<div class="bky-yacht-actions">
								<a href="https://wa.me/<?php echo esc_attr( str_replace( '+', '', $whatsapp ) ); ?>?text=<?php echo urlencode( 'Hi, I am interested in ' . get_the_title() ); ?>"
								   class="bky-yacht-btn bky-yacht-btn-whatsapp"
								   target="_blank">
									<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
									WHATSAPP
								</a>
								<a href="<?php the_permalink(); ?>" class="bky-yacht-btn bky-yacht-btn-view">
									VIEW NOW
								</a>
							</div>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
		</div>
	</div>
	<?php

	wp_reset_postdata();

	return ob_get_clean();
}
add_shortcode( 'yacht_cards', 'yr_yacht_cards_shortcode' );
