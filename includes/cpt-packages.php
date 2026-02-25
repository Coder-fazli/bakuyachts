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
	$contact_btn_text = get_post_meta( $post->ID, '_package_contact_btn_text', true );
	$package_faq = get_post_meta( $post->ID, '_package_faq', true );
	$head_description = get_post_meta( $post->ID, '_package_head_description', true );
	$bottom_description = get_post_meta( $post->ID, '_package_bottom_description', true );
	if ( ! is_array( $package_faq ) ) {
		$package_faq = array();
	}

	?>
	<!-- Head Description Editor -->
	<h3 style="margin-top: 0;"><?php _e( 'Head Description', 'yacht-rental' ); ?></h3>
	<p class="description" style="margin-bottom: 10px;"><?php _e( 'This content appears at the top of the page, right after the title and rating. Use for introductory text.', 'yacht-rental' ); ?></p>
	<?php
	wp_editor( $head_description, 'package_head_description', array(
		'textarea_name' => 'package_head_description',
		'textarea_rows' => 6,
		'media_buttons' => true,
		'teeny'         => false,
		'quicktags'     => true,
	) );
	?>

	<hr style="margin: 30px 0;" />

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
				<input type="text" id="whatsapp_number" name="whatsapp_number" value="<?php echo esc_attr( $whatsapp_number ); ?>" class="regular-text" placeholder="<?php esc_attr_e( 'e.g., +994554401020', 'yacht-rental' ); ?>" />
				<p class="description"><?php _e( 'Enter WhatsApp number with country code (e.g., +994554401020). This will be used for the "GET IN TOUCH" button.', 'yacht-rental' ); ?></p>
			</td>
		</tr>
		<tr>
			<th><label for="button_link"><?php _e( 'Custom Button Link (Optional)', 'yacht-rental' ); ?></label></th>
			<td>
				<input type="url" id="button_link" name="button_link" value="<?php echo esc_url( $button_link ); ?>" class="large-text" placeholder="<?php esc_attr_e( 'https://example.com/contact', 'yacht-rental' ); ?>" />
				<p class="description"><?php _e( 'If you want to use a custom link instead of WhatsApp, enter it here. Leave empty to use WhatsApp number.', 'yacht-rental' ); ?></p>
			</td>
		</tr>
		<tr>
			<th><label for="package_contact_btn_text"><?php _e( 'Get In Touch Button Text', 'yacht-rental' ); ?></label></th>
			<td>
				<input type="text" id="package_contact_btn_text" name="package_contact_btn_text" value="<?php echo esc_attr( $contact_btn_text ); ?>" class="regular-text" placeholder="GET IN TOUCH" />
				<p class="description"><?php _e( 'Custom text for the "Get In Touch" button. Leave empty for default.', 'yacht-rental' ); ?></p>
			</td>
		</tr>
	</table>

	<h3><?php _e( 'Package FAQ', 'yacht-rental' ); ?></h3>

	<?php $faq_title = get_post_meta( $post->ID, '_package_faq_title', true ); ?>
	<table class="form-table" style="margin-bottom: 15px;">
		<tr>
			<th><label for="package_faq_title"><?php _e( 'FAQ Section Title', 'yacht-rental' ); ?></label></th>
			<td>
				<input type="text" id="package_faq_title" name="package_faq_title" value="<?php echo esc_attr( $faq_title ); ?>" class="large-text" placeholder="<?php esc_attr_e( 'e.g., Tez-tez verilən suallar', 'yacht-rental' ); ?>" />
				<p class="description"><?php _e( 'Enter the FAQ section title in the current language (e.g., "Tez-tez verilən suallar" for Azerbaijani)', 'yacht-rental' ); ?></p>
			</td>
		</tr>
	</table>

	<div id="package-faq-container">
		<?php
		if ( ! empty( $package_faq ) ) {
			foreach ( $package_faq as $index => $faq_item ) {
				?>
				<div class="faq-item" style="margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; background: #f9f9f9;">
					<p>
						<label><strong><?php _e( 'Question', 'yacht-rental' ); ?></strong></label><br/>
						<input type="text" name="package_faq[<?php echo $index; ?>][question]" value="<?php echo esc_attr( $faq_item['question'] ?? '' ); ?>" class="large-text" />
					</p>
					<p>
						<label><strong><?php _e( 'Answer', 'yacht-rental' ); ?></strong></label><br/>
						<textarea name="package_faq[<?php echo $index; ?>][answer]" rows="3" class="large-text"><?php echo esc_textarea( $faq_item['answer'] ?? '' ); ?></textarea>
					</p>
					<button type="button" class="button remove-faq-item"><?php _e( 'Remove FAQ', 'yacht-rental' ); ?></button>
				</div>
				<?php
			}
		}
		?>
	</div>
	<button type="button" id="add-faq-item" class="button"><?php _e( 'Add FAQ Item', 'yacht-rental' ); ?></button>

	<script>
	jQuery(document).ready(function($) {
		var faqIndex = <?php echo count( $package_faq ); ?>;

		$('#add-faq-item').on('click', function() {
			var faqHtml = '<div class="faq-item" style="margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; background: #f9f9f9;">' +
				'<p><label><strong><?php _e( 'Question', 'yacht-rental' ); ?></strong></label><br/>' +
				'<input type="text" name="package_faq[' + faqIndex + '][question]" value="" class="large-text" /></p>' +
				'<p><label><strong><?php _e( 'Answer', 'yacht-rental' ); ?></strong></label><br/>' +
				'<textarea name="package_faq[' + faqIndex + '][answer]" rows="3" class="large-text"></textarea></p>' +
				'<button type="button" class="button remove-faq-item"><?php _e( 'Remove FAQ', 'yacht-rental' ); ?></button>' +
				'</div>';
			$('#package-faq-container').append(faqHtml);
			faqIndex++;
		});

		$(document).on('click', '.remove-faq-item', function() {
			$(this).closest('.faq-item').remove();
		});
	});
	</script>

	<hr style="margin: 30px 0;" />

	<!-- Bottom Description Editor -->
	<h3><?php _e( 'Bottom Description', 'yacht-rental' ); ?></h3>
	<p class="description" style="margin-bottom: 10px;"><?php _e( 'This content appears at the bottom of the page, after the package features section. Use for additional details, terms, or any extra information.', 'yacht-rental' ); ?></p>
	<?php
	wp_editor( $bottom_description, 'package_bottom_description', array(
		'textarea_name' => 'package_bottom_description',
		'textarea_rows' => 8,
		'media_buttons' => true,
		'teeny'         => false,
		'quicktags'     => true,
	) );
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

	// Save head description
	if ( isset( $_POST['package_head_description'] ) ) {
		update_post_meta( $post_id, '_package_head_description', wp_kses_post( $_POST['package_head_description'] ) );
	}

	// Save bottom description
	if ( isset( $_POST['package_bottom_description'] ) ) {
		update_post_meta( $post_id, '_package_bottom_description', wp_kses_post( $_POST['package_bottom_description'] ) );
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

	// Save contact button text
	if ( isset( $_POST['package_contact_btn_text'] ) ) {
		update_post_meta( $post_id, '_package_contact_btn_text', sanitize_text_field( $_POST['package_contact_btn_text'] ) );
	}

	// Save FAQ title
	if ( isset( $_POST['package_faq_title'] ) ) {
		update_post_meta( $post_id, '_package_faq_title', sanitize_text_field( $_POST['package_faq_title'] ) );
	}

	// Save FAQ
	if ( isset( $_POST['package_faq'] ) && is_array( $_POST['package_faq'] ) ) {
		$faq_data = array();
		foreach ( $_POST['package_faq'] as $faq_item ) {
			if ( ! empty( $faq_item['question'] ) && ! empty( $faq_item['answer'] ) ) {
				$faq_data[] = array(
					'question' => sanitize_text_field( $faq_item['question'] ),
					'answer'   => sanitize_textarea_field( $faq_item['answer'] ),
				);
			}
		}
		update_post_meta( $post_id, '_package_faq', $faq_data );
	} else {
		delete_post_meta( $post_id, '_package_faq' );
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
	if ( ! get_option( 'yr_packages_permalinks_flushed_v2' ) ) {
		yr_packages_rewrite_flush();
		update_option( 'yr_packages_permalinks_flushed_v2', true );
	}
}
add_action( 'admin_init', 'yr_packages_check_flush' );

// Add Polylang support - Register CPT for translation
function yr_packages_polylang_register_cpt( $post_types, $is_settings ) {
	$post_types['cpt_packages'] = 'cpt_packages';
	return $post_types;
}
add_filter( 'pll_get_post_types', 'yr_packages_polylang_register_cpt', 10, 2 );

// Force enable Packages CPT in Polylang settings
function yr_packages_polylang_enable_cpt() {
	if ( ! function_exists( 'pll_languages_list' ) ) {
		return;
	}

	$options = get_option( 'polylang' );
	if ( $options && is_array( $options ) ) {
		if ( ! isset( $options['post_types'] ) ) {
			$options['post_types'] = array();
		}
		if ( ! in_array( 'cpt_packages', $options['post_types'] ) ) {
			$options['post_types'][] = 'cpt_packages';
			update_option( 'polylang', $options );
		}
	}
}
add_action( 'admin_init', 'yr_packages_polylang_enable_cpt' );

// Ensure Packages archive filters by current language
function yr_packages_archive_filter_language( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	// Only apply to packages archive
	if ( ! is_post_type_archive( 'cpt_packages' ) ) {
		return;
	}

	// Let Polylang handle the language filtering if it's active
	if ( function_exists( 'pll_current_language' ) ) {
		$current_lang = pll_current_language();
		if ( $current_lang ) {
			$query->set( 'lang', $current_lang );
		}
	}
}
add_action( 'pre_get_posts', 'yr_packages_archive_filter_language' );

/**
 * Package Cards Grid Shortcode
 *
 * Usage examples:
 * [package_cards]                                    - Show all packages (current language)
 * [package_cards limit="6"]                          - Show 6 packages
 * [package_cards columns="4"]                        - Show in 4 columns
 * [package_cards orderby="title" order="ASC"]        - Order by title ascending
 * [package_cards ids="123,456,789"]                  - Show specific packages by ID
 * [package_cards lang="az"]                          - Show packages in Azerbaijani language
 * [package_cards lang="all"]                         - Show packages from all languages
 */
function yr_package_cards_shortcode( $atts ) {
	$atts = shortcode_atts( array(
		'limit'   => -1,
		'columns' => 3,
		'orderby' => 'date',
		'order'   => 'DESC',
		'ids'     => '',
		'lang'    => '',
	), $atts, 'package_cards' );

	// Query arguments
	$query_args = array(
		'post_type'      => 'cpt_packages',
		'posts_per_page' => intval( $atts['limit'] ),
		'orderby'        => sanitize_text_field( $atts['orderby'] ),
		'order'          => sanitize_text_field( $atts['order'] ),
		'post_status'    => 'publish',
	);

	// Polylang language filter
	if ( function_exists( 'pll_current_language' ) ) {
		$lang_code = ! empty( $atts['lang'] ) ? sanitize_text_field( $atts['lang'] ) : '';

		if ( $lang_code === 'all' ) {
			$query_args['lang'] = '';
		} elseif ( ! empty( $lang_code ) && in_array( $lang_code, array( 'az', 'ru', 'en' ) ) ) {
			$query_args['lang'] = $lang_code;
		} else {
			$query_args['lang'] = pll_current_language();
		}
	}

	// Filter by specific IDs
	if ( ! empty( $atts['ids'] ) ) {
		$ids = array_map( 'intval', explode( ',', $atts['ids'] ) );
		$query_args['post__in'] = $ids;
		$query_args['orderby'] = 'post__in';
	}

	$packages = new WP_Query( $query_args );

	if ( ! $packages->have_posts() ) {
		return '<p>' . __( 'No packages found.', 'yacht-rental' ) . '</p>';
	}

	ob_start();
	?>
	<style>
	.yr-package-shortcode-wrapper {
	  padding: 40px 0;
	  background: #ffffff;
	  width: 100%;
	  box-sizing: border-box;
	}
	.yr-package-shortcode-container {
	  max-width: 1600px;
	  width: 100%;
	  margin: 0 auto;
	  padding: 0 40px;
	  box-sizing: border-box;
	}
	.yr-package-grid {
	  display: flex;
	  flex-wrap: wrap;
	  gap: 30px;
	  width: 100%;
	}
	.yr-package-grid .bky-package-card {
	  flex: 1 1 calc(33.333% - 20px);
	  min-width: 0;
	  max-width: calc(33.333% - 20px);
	  background: #fff;
	  border-radius: 16px;
	  overflow: hidden;
	  box-shadow: 0 2px 12px rgba(0,0,0,0.08);
	  transition: transform 0.3s ease, box-shadow 0.3s ease;
	  display: flex;
	  flex-direction: column;
	  position: relative;
	}
	.yr-package-grid .bky-package-card:hover {
	  transform: translateY(-6px);
	  box-shadow: 0 6px 24px rgba(0,0,0,0.12);
	}
	@media (max-width: 1024px) {
	  .yr-package-shortcode-container {
	    padding: 0 40px;
	  }
	  .yr-package-grid {
	    gap: 25px;
	  }
	  .yr-package-grid .bky-package-card {
	    flex: 1 1 calc(50% - 15px);
	    min-width: 0;
	    max-width: calc(50% - 15px);
	  }
	}
	@media (max-width: 768px) {
	  .yr-package-shortcode-container {
	    padding: 0 20px;
	  }
	  .yr-package-grid {
	    gap: 20px;
	  }
	  .yr-package-grid .bky-package-card {
	    flex: 1 1 100%;
	    min-width: 100%;
	    max-width: 100%;
	  }
	}
	.bky-package-image {
	  position: relative;
	  width: 100%;
	  height: 280px;
	  overflow: hidden;
	}
	.bky-package-image img {
	  width: 100%;
	  height: 100%;
	  object-fit: cover;
	  transition: transform 0.5s ease;
	}
	.bky-package-card:hover .bky-package-image img {
	  transform: scale(1.05);
	}
	.bky-package-content {
	  padding: 25px;
	  flex: 1;
	  display: flex;
	  flex-direction: column;
	}
	.bky-package-title {
	  margin-bottom: 15px;
	}
	.bky-package-title h3 {
	  font-size: 22px;
	  font-weight: 600;
	  color: #1a1a1a;
	  margin: 0;
	  line-height: 1.3;
	}
	.bky-package-title h3 a {
	  color: #1a1a1a;
	  text-decoration: none;
	}
	.bky-package-title h3 a:hover {
	  color: #1a1a1a;
	}
	.bky-package-excerpt {
	  color: #666;
	  font-size: 14px;
	  line-height: 1.6;
	  margin-bottom: 25px;
	  flex: 1;
	}
	.bky-package-buttons {
	  display: flex;
	  gap: 12px;
	  margin-top: auto;
	}
	.bky-package-btn {
	  flex: 1;
	  padding: 12px 18px;
	  border-radius: 0;
	  font-weight: 600;
	  font-size: 13px;
	  text-decoration: none;
	  text-align: center;
	  transition: all 0.3s ease;
	  border: none;
	  cursor: pointer;
	  display: flex;
	  align-items: center;
	  justify-content: center;
	  gap: 8px;
	  white-space: nowrap;
	  min-height: 46px;
	  box-sizing: border-box;
	  text-transform: uppercase;
	}
	.bky-package-btn svg {
	  width: 17px;
	  height: 17px;
	  flex-shrink: 0;
	}
	.bky-package-btn-whatsapp {
	  background: #25D366;
	  color: white;
	}
	.bky-package-btn-whatsapp:hover {
	  background: #25D366;
	  color: white;
	  transform: translateY(-2px);
	}
	.bky-package-btn-view {
	  background: #A62946;
	  color: white;
	}
	.bky-package-btn-view:hover {
	  background: #A62946;
	  color: white;
	  transform: translateY(-2px);
	}
	@media (max-width: 1500px) {
	  .bky-package-btn {
	    padding: 12px 14px;
	    font-size: 12px;
	    gap: 6px;
	    min-height: 44px;
	  }
	  .bky-package-btn svg {
	    width: 15px;
	    height: 15px;
	  }
	}
	@media (max-width: 768px) {
	  .bky-package-buttons {
	    flex-direction: column;
	    gap: 10px;
	  }
	  .bky-package-btn {
	    width: 100%;
	    padding: 12px 20px;
	    font-size: 13px;
	    min-height: 46px;
	    gap: 8px;
	  }
	  .bky-package-btn svg {
	    width: 16px;
	    height: 16px;
	  }
	}
	</style>

	<div class="yr-package-shortcode-wrapper">
		<div class="yr-package-shortcode-container">
			<div class="yr-package-grid">
				<?php
				while ( $packages->have_posts() ) : $packages->the_post();
					$whatsapp = get_post_meta( get_the_ID(), '_whatsapp_number', true );
					if ( empty( $whatsapp ) ) {
						$whatsapp = '+994554401020';
					}
					?>
					<div class="bky-package-card">
						<div class="bky-package-image">
							<?php if ( has_post_thumbnail() ) : ?>
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail( 'large' ); ?>
								</a>
							<?php endif; ?>
						</div>

						<div class="bky-package-content">
							<div class="bky-package-title">
								<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							</div>

							<?php if ( has_excerpt() ) : ?>
								<div class="bky-package-excerpt">
									<?php echo wp_trim_words( get_the_excerpt(), 20 ); ?>
								</div>
							<?php endif; ?>

							<div class="bky-package-buttons">
								<a href="https://wa.me/994554401020?text=<?php echo urlencode( 'Hi, I am interested in the ' . get_the_title() . ' package' ); ?>"
								   class="bky-package-btn bky-package-btn-whatsapp"
								   target="_blank">
									<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
									WHATSAPP
								</a>
								<?php
								$sc_btn_text = get_post_meta( get_the_ID(), '_package_contact_btn_text', true );
								?>
								<a href="<?php the_permalink(); ?>" class="bky-package-btn bky-package-btn-view">
									<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
									<?php
									$sc_btn_default = function_exists( 'pll__' ) ? pll__( 'GET IN TOUCH' ) : __( 'GET IN TOUCH', 'yacht-rental' );
									echo esc_html( ! empty( $sc_btn_text ) ? $sc_btn_text : $sc_btn_default );
									?>
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
add_shortcode( 'package_cards', 'yr_package_cards_shortcode' );

/**
 * Package Button Colors Admin Settings
 */

// Add submenu page under Packages
function yr_package_button_colors_menu() {
	add_submenu_page(
		'edit.php?post_type=cpt_packages',
		__( 'Button Colors', 'yacht-rental' ),
		__( 'Button Colors', 'yacht-rental' ),
		'manage_options',
		'yr-package-button-colors',
		'yr_package_button_colors_page'
	);
}
add_action( 'admin_menu', 'yr_package_button_colors_menu' );

// Register settings
function yr_package_button_colors_settings_init() {
	register_setting( 'yr_package_button_colors', 'yr_pkg_whatsapp_btn_bg', array(
		'type' => 'string',
		'default' => '#25D366',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	register_setting( 'yr_package_button_colors', 'yr_pkg_whatsapp_btn_text', array(
		'type' => 'string',
		'default' => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	register_setting( 'yr_package_button_colors', 'yr_pkg_whatsapp_btn_hover_bg', array(
		'type' => 'string',
		'default' => '#128C7E',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	register_setting( 'yr_package_button_colors', 'yr_pkg_view_btn_bg', array(
		'type' => 'string',
		'default' => '#A62946',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	register_setting( 'yr_package_button_colors', 'yr_pkg_view_btn_text', array(
		'type' => 'string',
		'default' => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	register_setting( 'yr_package_button_colors', 'yr_pkg_view_btn_hover_bg', array(
		'type' => 'string',
		'default' => '#8B1F3A',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
}
add_action( 'admin_init', 'yr_package_button_colors_settings_init' );

// Enqueue color picker
function yr_package_button_colors_admin_scripts( $hook ) {
	if ( 'cpt_packages_page_yr-package-button-colors' !== $hook ) {
		return;
	}
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );
}
add_action( 'admin_enqueue_scripts', 'yr_package_button_colors_admin_scripts' );

// Settings page HTML
function yr_package_button_colors_page() {
	$whatsapp_bg = get_option( 'yr_pkg_whatsapp_btn_bg', '#25D366' );
	$whatsapp_text = get_option( 'yr_pkg_whatsapp_btn_text', '#ffffff' );
	$whatsapp_hover = get_option( 'yr_pkg_whatsapp_btn_hover_bg', '#128C7E' );
	$view_bg = get_option( 'yr_pkg_view_btn_bg', '#A62946' );
	$view_text = get_option( 'yr_pkg_view_btn_text', '#ffffff' );
	$view_hover = get_option( 'yr_pkg_view_btn_hover_bg', '#8B1F3A' );
	?>
	<div class="wrap">
		<h1><?php _e( 'Package Button Colors', 'yacht-rental' ); ?></h1>
		<p><?php _e( 'Customize the colors of WhatsApp and View Details buttons on package cards.', 'yacht-rental' ); ?></p>

		<form method="post" action="options.php">
			<?php settings_fields( 'yr_package_button_colors' ); ?>

			<style>
				.yr-color-settings { max-width: 800px; }
				.yr-color-section { background: #fff; padding: 25px; margin-bottom: 20px; border: 1px solid #ccd0d4; border-radius: 4px; }
				.yr-color-section h2 { margin-top: 0; padding-bottom: 15px; border-bottom: 1px solid #eee; }
				.yr-color-row { display: flex; align-items: center; margin-bottom: 20px; }
				.yr-color-row label { width: 200px; font-weight: 600; }
				.yr-color-row input[type="text"] { width: 100px; }
				.yr-preview { margin-top: 30px; padding: 20px; background: #f5f5f5; border-radius: 4px; }
				.yr-preview-btn { display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; font-weight: 600; font-size: 13px; text-decoration: none; border: none; cursor: pointer; margin-right: 15px; }
			</style>

			<div class="yr-color-settings">
				<div class="yr-color-section">
					<h2><?php _e( 'WhatsApp Button', 'yacht-rental' ); ?></h2>

					<div class="yr-color-row">
						<label for="yr_pkg_whatsapp_btn_bg"><?php _e( 'Background Color', 'yacht-rental' ); ?></label>
						<input type="text" id="yr_pkg_whatsapp_btn_bg" name="yr_pkg_whatsapp_btn_bg" value="<?php echo esc_attr( $whatsapp_bg ); ?>" class="yr-pkg-color-picker" />
					</div>

					<div class="yr-color-row">
						<label for="yr_pkg_whatsapp_btn_text"><?php _e( 'Text Color', 'yacht-rental' ); ?></label>
						<input type="text" id="yr_pkg_whatsapp_btn_text" name="yr_pkg_whatsapp_btn_text" value="<?php echo esc_attr( $whatsapp_text ); ?>" class="yr-pkg-color-picker" />
					</div>

					<div class="yr-color-row">
						<label for="yr_pkg_whatsapp_btn_hover_bg"><?php _e( 'Hover Background Color', 'yacht-rental' ); ?></label>
						<input type="text" id="yr_pkg_whatsapp_btn_hover_bg" name="yr_pkg_whatsapp_btn_hover_bg" value="<?php echo esc_attr( $whatsapp_hover ); ?>" class="yr-pkg-color-picker" />
					</div>
				</div>

				<div class="yr-color-section">
					<h2><?php _e( 'View Details Button', 'yacht-rental' ); ?></h2>

					<div class="yr-color-row">
						<label for="yr_pkg_view_btn_bg"><?php _e( 'Background Color', 'yacht-rental' ); ?></label>
						<input type="text" id="yr_pkg_view_btn_bg" name="yr_pkg_view_btn_bg" value="<?php echo esc_attr( $view_bg ); ?>" class="yr-pkg-color-picker" />
					</div>

					<div class="yr-color-row">
						<label for="yr_pkg_view_btn_text"><?php _e( 'Text Color', 'yacht-rental' ); ?></label>
						<input type="text" id="yr_pkg_view_btn_text" name="yr_pkg_view_btn_text" value="<?php echo esc_attr( $view_text ); ?>" class="yr-pkg-color-picker" />
					</div>

					<div class="yr-color-row">
						<label for="yr_pkg_view_btn_hover_bg"><?php _e( 'Hover Background Color', 'yacht-rental' ); ?></label>
						<input type="text" id="yr_pkg_view_btn_hover_bg" name="yr_pkg_view_btn_hover_bg" value="<?php echo esc_attr( $view_hover ); ?>" class="yr-pkg-color-picker" />
					</div>
				</div>

				<div class="yr-preview">
					<h3><?php _e( 'Preview', 'yacht-rental' ); ?></h3>
					<button type="button" class="yr-preview-btn" id="yr-pkg-preview-whatsapp" style="background: <?php echo esc_attr( $whatsapp_bg ); ?>; color: <?php echo esc_attr( $whatsapp_text ); ?>;">
						<svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
						WHATSAPP
					</button>
					<button type="button" class="yr-preview-btn" id="yr-pkg-preview-view" style="background: <?php echo esc_attr( $view_bg ); ?>; color: <?php echo esc_attr( $view_text ); ?>;">
						<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
						GET IN TOUCH
					</button>
				</div>
			</div>

			<?php submit_button( __( 'Save Colors', 'yacht-rental' ) ); ?>
		</form>
	</div>

	<script>
	jQuery(document).ready(function($) {
		$('.yr-pkg-color-picker').wpColorPicker({
			change: function(event, ui) {
				updatePkgPreview();
			}
		});

		function updatePkgPreview() {
			setTimeout(function() {
				var waBg = $('#yr_pkg_whatsapp_btn_bg').val();
				var waText = $('#yr_pkg_whatsapp_btn_text').val();
				var viewBg = $('#yr_pkg_view_btn_bg').val();
				var viewText = $('#yr_pkg_view_btn_text').val();

				$('#yr-pkg-preview-whatsapp').css({ 'background': waBg, 'color': waText });
				$('#yr-pkg-preview-view').css({ 'background': viewBg, 'color': viewText });
			}, 100);
		}
	});
	</script>
	<?php
}

// Output dynamic button styles on frontend for packages
function yr_output_package_button_colors_css() {
	if ( is_admin() ) {
		return;
	}

	$whatsapp_bg = get_option( 'yr_pkg_whatsapp_btn_bg', '#25D366' );
	$whatsapp_text = get_option( 'yr_pkg_whatsapp_btn_text', '#ffffff' );
	$whatsapp_hover = get_option( 'yr_pkg_whatsapp_btn_hover_bg', '#128C7E' );
	$view_bg = get_option( 'yr_pkg_view_btn_bg', '#A62946' );
	$view_text = get_option( 'yr_pkg_view_btn_text', '#ffffff' );
	$view_hover = get_option( 'yr_pkg_view_btn_hover_bg', '#8B1F3A' );

	?>
	<style id="yr-package-button-colors-css">
	/* Package Card Buttons - Dynamic Colors */
	.bky-package-btn-whatsapp {
		background: <?php echo esc_attr( $whatsapp_bg ); ?> !important;
		color: <?php echo esc_attr( $whatsapp_text ); ?> !important;
	}
	.bky-package-btn-whatsapp:hover {
		background: <?php echo esc_attr( $whatsapp_hover ); ?> !important;
		color: <?php echo esc_attr( $whatsapp_text ); ?> !important;
	}
	.bky-package-btn-view {
		background: <?php echo esc_attr( $view_bg ); ?> !important;
		color: <?php echo esc_attr( $view_text ); ?> !important;
	}
	.bky-package-btn-view:hover {
		background: <?php echo esc_attr( $view_hover ); ?> !important;
		color: <?php echo esc_attr( $view_text ); ?> !important;
	}
	</style>
	<?php
}
add_action( 'wp_head', 'yr_output_package_button_colors_css', 100 );

/**
 * Package Archive SEO Settings (per language)
 */

function yr_packages_archive_seo_menu() {
	add_submenu_page(
		'edit.php?post_type=cpt_packages',
		__( 'Archive SEO', 'yacht-rental' ),
		__( 'Archive SEO', 'yacht-rental' ),
		'manage_options',
		'yr-packages-archive-seo',
		'yr_packages_archive_seo_page'
	);
}
add_action( 'admin_menu', 'yr_packages_archive_seo_menu' );

function yr_packages_archive_seo_page() {
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

	if ( isset( $_POST['yr_packages_seo_save'] ) && check_admin_referer( 'yr_packages_seo_nonce' ) ) {
		foreach ( $languages as $lang_code => $lang_name ) {
			update_option( "yr_packages_archive_meta_title_{$lang_code}", sanitize_text_field( $_POST["yr_packages_meta_title_{$lang_code}"] ?? '' ) );
			update_option( "yr_packages_archive_meta_desc_{$lang_code}", sanitize_textarea_field( $_POST["yr_packages_meta_desc_{$lang_code}"] ?? '' ) );
		}
		echo '<div class="notice notice-success is-dismissible"><p>' . __( 'SEO settings saved.', 'yacht-rental' ) . '</p></div>';
	}
	?>
	<div class="wrap">
		<h1><?php _e( 'Packages Archive — SEO Settings', 'yacht-rental' ); ?></h1>
		<p class="description"><?php _e( 'Set the meta title and meta description for the Packages archive page. These override Rank Math for each language.', 'yacht-rental' ); ?></p>
		<form method="post">
			<?php wp_nonce_field( 'yr_packages_seo_nonce' ); ?>
			<?php foreach ( $languages as $lang_code => $lang_name ) : ?>
				<h2 style="margin-top:25px;padding-top:15px;border-top:1px solid #ccc;"><?php echo esc_html( $lang_name ); ?> (<?php echo strtoupper( $lang_code ); ?>)</h2>
				<table class="form-table">
					<tr>
						<th><label><?php _e( 'Meta Title', 'yacht-rental' ); ?></label></th>
						<td><input type="text" name="yr_packages_meta_title_<?php echo esc_attr( $lang_code ); ?>" value="<?php echo esc_attr( get_option( "yr_packages_archive_meta_title_{$lang_code}", '' ) ); ?>" class="large-text" placeholder="<?php esc_attr_e( 'Yacht Packages Baku | Party & Events', 'yacht-rental' ); ?>" /></td>
					</tr>
					<tr>
						<th><label><?php _e( 'Meta Description', 'yacht-rental' ); ?></label></th>
						<td><textarea name="yr_packages_meta_desc_<?php echo esc_attr( $lang_code ); ?>" class="large-text" rows="3" placeholder="<?php esc_attr_e( 'Explore our yacht rental packages in Baku...', 'yacht-rental' ); ?>"><?php echo esc_textarea( get_option( "yr_packages_archive_meta_desc_{$lang_code}", '' ) ); ?></textarea></td>
					</tr>
				</table>
			<?php endforeach; ?>
			<p class="submit"><input type="submit" name="yr_packages_seo_save" class="button button-primary" value="<?php _e( 'Save SEO Settings', 'yacht-rental' ); ?>" /></p>
		</form>
	</div>
	<?php
}
