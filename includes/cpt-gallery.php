<?php
/**
 * Custom Post Type: Gallery
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
add_action( 'init', 'yr_register_gallery_cpt', 0 );
function yr_register_gallery_cpt() {
	register_post_type( 'cpt_gallery', array(
		'labels' => array(
			'name'          => __( 'Galleries', 'yacht-rental' ),
			'singular_name' => __( 'Gallery', 'yacht-rental' ),
			'add_new'       => __( 'Add New Gallery', 'yacht-rental' ),
			'add_new_item'  => __( 'Add New Gallery', 'yacht-rental' ),
			'edit_item'     => __( 'Edit Gallery', 'yacht-rental' ),
			'all_items'     => __( 'All Galleries', 'yacht-rental' ),
		),
		'public'       => true,
		'show_ui'      => true,
		'show_in_menu' => true,
		'menu_icon'    => 'dashicons-format-gallery',
		'menu_position'=> 7,
		'supports'     => array( 'title' ),
		'has_archive'  => false,
		'show_in_rest' => true,
		'rewrite'      => array( 'slug' => 'gallery' ),
	));
}

// Polylang support
add_filter( 'pll_get_post_types', 'yr_gallery_polylang', 10, 2 );
function yr_gallery_polylang( $post_types, $is_settings ) {
	$post_types['cpt_gallery'] = 'cpt_gallery';
	return $post_types;
}

// =====================================================
// META BOX FOR IMAGES
// =====================================================
add_action( 'add_meta_boxes', 'yr_gallery_add_meta_box' );
function yr_gallery_add_meta_box() {
	add_meta_box(
		'yr_gallery_images',
		__( 'Gallery Images', 'yacht-rental' ),
		'yr_gallery_meta_box_html',
		'cpt_gallery',
		'normal',
		'high'
	);
}

function yr_gallery_meta_box_html( $post ) {
	wp_nonce_field( 'yr_gallery_save', 'yr_gallery_nonce' );

	$images = get_post_meta( $post->ID, '_yr_gallery_images', true );
	$image_ids = ! empty( $images ) ? $images : '';

	wp_enqueue_media();
	?>
	<style>
		#yr-gallery-preview { display: flex; flex-wrap: wrap; gap: 10px; margin: 15px 0; }
		#yr-gallery-preview .yr-img-item { position: relative; width: 150px; height: 150px; }
		#yr-gallery-preview .yr-img-item img { width: 100%; height: 100%; object-fit: cover; border-radius: 4px; border: 2px solid #ddd; }
		#yr-gallery-preview .yr-img-item:hover img { border-color: #0073aa; }
		#yr-gallery-preview .yr-remove { position: absolute; top: -8px; right: -8px; background: #dc3232; color: #fff; border: none; border-radius: 50%; width: 24px; height: 24px; cursor: pointer; font-size: 16px; line-height: 22px; }
		#yr-gallery-preview .yr-remove:hover { background: #a00; }
		.yr-shortcode-box { background: #f0f0f0; padding: 15px; border-radius: 4px; margin-top: 20px; }
		.yr-shortcode-box code { background: #fff; padding: 8px 15px; display: inline-block; font-size: 14px; border-radius: 3px; }
	</style>

	<p><strong><?php _e( 'Click the button below to select images for this gallery:', 'yacht-rental' ); ?></strong></p>

	<input type="hidden" id="yr-gallery-ids" name="yr_gallery_images" value="<?php echo esc_attr( $image_ids ); ?>">

	<div id="yr-gallery-preview">
		<?php
		if ( ! empty( $image_ids ) ) {
			$ids = explode( ',', $image_ids );
			foreach ( $ids as $id ) {
				$url = wp_get_attachment_image_url( intval( $id ), 'thumbnail' );
				if ( $url ) {
					echo '<div class="yr-img-item" data-id="' . esc_attr( $id ) . '">';
					echo '<img src="' . esc_url( $url ) . '" alt="">';
					echo '<button type="button" class="yr-remove">&times;</button>';
					echo '</div>';
				}
			}
		}
		?>
	</div>

	<p>
		<button type="button" id="yr-select-images" class="button button-primary button-large">
			<span class="dashicons dashicons-images-alt2" style="vertical-align: middle; margin-right: 5px;"></span>
			<?php _e( 'Select Images', 'yacht-rental' ); ?>
		</button>
		<button type="button" id="yr-clear-images" class="button" style="margin-left: 10px;">
			<?php _e( 'Clear All', 'yacht-rental' ); ?>
		</button>
	</p>

	<?php if ( $post->ID && get_post_status( $post->ID ) === 'publish' ) : ?>
	<div class="yr-shortcode-box">
		<strong><?php _e( 'Shortcode:', 'yacht-rental' ); ?></strong><br><br>
		<code id="yr-shortcode">[yr_gallery id="<?php echo $post->ID; ?>"]</code>
		<button type="button" class="button" onclick="navigator.clipboard.writeText(document.getElementById('yr-shortcode').innerText); this.innerText='Copied!';">
			<?php _e( 'Copy', 'yacht-rental' ); ?>
		</button>
	</div>
	<?php endif; ?>

	<script>
	jQuery(document).ready(function($) {
		var frame;

		$('#yr-select-images').on('click', function(e) {
			e.preventDefault();

			if (frame) {
				frame.open();
				return;
			}

			frame = wp.media({
				title: '<?php _e( 'Select Gallery Images', 'yacht-rental' ); ?>',
				button: { text: '<?php _e( 'Add to Gallery', 'yacht-rental' ); ?>' },
				multiple: true
			});

			frame.on('select', function() {
				var selection = frame.state().get('selection');
				var ids = $('#yr-gallery-ids').val() ? $('#yr-gallery-ids').val().split(',') : [];

				selection.each(function(attachment) {
					var id = attachment.id;
					if (ids.indexOf(String(id)) === -1) {
						ids.push(id);
						var url = attachment.attributes.sizes && attachment.attributes.sizes.thumbnail
							? attachment.attributes.sizes.thumbnail.url
							: attachment.attributes.url;
						$('#yr-gallery-preview').append(
							'<div class="yr-img-item" data-id="' + id + '">' +
							'<img src="' + url + '" alt="">' +
							'<button type="button" class="yr-remove">&times;</button>' +
							'</div>'
						);
					}
				});

				$('#yr-gallery-ids').val(ids.join(','));
			});

			frame.open();
		});

		$(document).on('click', '.yr-remove', function() {
			var $item = $(this).closest('.yr-img-item');
			var id = $item.data('id');
			var ids = $('#yr-gallery-ids').val().split(',').filter(function(i) { return i != id; });
			$('#yr-gallery-ids').val(ids.join(','));
			$item.remove();
		});

		$('#yr-clear-images').on('click', function() {
			if (confirm('<?php _e( 'Remove all images?', 'yacht-rental' ); ?>')) {
				$('#yr-gallery-preview').empty();
				$('#yr-gallery-ids').val('');
			}
		});
	});
	</script>
	<?php
}

// Save meta box
add_action( 'save_post_cpt_gallery', 'yr_gallery_save_meta' );
function yr_gallery_save_meta( $post_id ) {
	if ( ! isset( $_POST['yr_gallery_nonce'] ) || ! wp_verify_nonce( $_POST['yr_gallery_nonce'], 'yr_gallery_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$images = isset( $_POST['yr_gallery_images'] ) ? sanitize_text_field( $_POST['yr_gallery_images'] ) : '';
	update_post_meta( $post_id, '_yr_gallery_images', $images );
}

// Admin columns
add_filter( 'manage_cpt_gallery_posts_columns', 'yr_gallery_columns' );
function yr_gallery_columns( $columns ) {
	$new = array();
	foreach ( $columns as $key => $val ) {
		$new[$key] = $val;
		if ( $key === 'title' ) {
			$new['images'] = __( 'Images', 'yacht-rental' );
			$new['shortcode'] = __( 'Shortcode', 'yacht-rental' );
		}
	}
	return $new;
}

add_action( 'manage_cpt_gallery_posts_custom_column', 'yr_gallery_column_content', 10, 2 );
function yr_gallery_column_content( $column, $post_id ) {
	if ( $column === 'images' ) {
		$images = get_post_meta( $post_id, '_yr_gallery_images', true );
		$count = $images ? count( explode( ',', $images ) ) : 0;
		echo '<span style="background:#0073aa;color:#fff;padding:4px 10px;border-radius:3px;font-weight:bold;">' . $count . '</span>';
	}
	if ( $column === 'shortcode' ) {
		echo '<code style="background:#f5f5f5;padding:5px 10px;">[yr_gallery id="' . $post_id . '"]</code>';
	}
}

// =====================================================
// SHORTCODE: [yr_gallery id="123"]
// =====================================================
add_shortcode( 'yr_gallery', 'yr_gallery_shortcode' );
function yr_gallery_shortcode( $atts ) {
	$atts = shortcode_atts( array(
		'id'      => 0,
		'columns' => 3,
		'gap'     => 15,
	), $atts );

	$id = intval( $atts['id'] );
	if ( ! $id ) {
		return '<!-- yr_gallery: No ID specified -->';
	}

	$images = get_post_meta( $id, '_yr_gallery_images', true );
	if ( empty( $images ) ) {
		return '<!-- yr_gallery: No images found for ID ' . $id . ' -->';
	}

	$image_ids = array_filter( array_map( 'intval', explode( ',', $images ) ) );
	if ( empty( $image_ids ) ) {
		return '<!-- yr_gallery: No valid image IDs -->';
	}

	// Enqueue scripts
	wp_enqueue_script( 'imagesloaded' );
	wp_enqueue_script( 'masonry' );
	wp_enqueue_style( 'dashicons' );

	$cols = intval( $atts['columns'] );
	$gap = intval( $atts['gap'] );
	$uid = 'yr-gal-' . $id . '-' . wp_rand( 100, 999 );

	ob_start();
	?>
	<style>
	.yr-masonry-gallery { margin: 30px 0; }
	.yr-masonry-grid { margin-left: -<?php echo $gap; ?>px; }
	.yr-masonry-grid::after { content: ''; display: block; clear: both; }
	.yr-gal-item { float: left; padding-left: <?php echo $gap; ?>px; margin-bottom: <?php echo $gap; ?>px; box-sizing: border-box; }
	.yr-masonry-gallery[data-cols="2"] .yr-gal-item { width: 50%; }
	.yr-masonry-gallery[data-cols="3"] .yr-gal-item { width: 33.333%; }
	.yr-masonry-gallery[data-cols="4"] .yr-gal-item { width: 25%; }
	@media (max-width: 768px) {
		.yr-masonry-gallery[data-cols="3"] .yr-gal-item,
		.yr-masonry-gallery[data-cols="4"] .yr-gal-item { width: 50%; }
	}
	@media (max-width: 480px) { .yr-gal-item { width: 100% !important; } }
	.yr-gal-item a { display: block; position: relative; overflow: hidden; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
	.yr-gal-item a:hover { box-shadow: 0 8px 25px rgba(0,0,0,0.2); }
	.yr-gal-item img { display: block; width: 100%; height: auto; transition: transform 0.3s; }
	.yr-gal-item a:hover img { transform: scale(1.05); }
	.yr-gal-overlay { position: absolute; inset: 0; background: rgba(0,0,0,0.4); opacity: 0; transition: opacity 0.3s; display: flex; align-items: center; justify-content: center; }
	.yr-gal-item a:hover .yr-gal-overlay { opacity: 1; }
	.yr-gal-overlay .dashicons { color: #fff; font-size: 32px; width: 32px; height: 32px; }
	/* Lightbox */
	.yr-lightbox { position: fixed; inset: 0; background: rgba(0,0,0,0.95); z-index: 999999; display: none; align-items: center; justify-content: center; }
	.yr-lightbox.active { display: flex; }
	.yr-lightbox img { max-width: 90%; max-height: 90vh; border-radius: 4px; }
	.yr-lightbox-close { position: absolute; top: 20px; right: 30px; color: #fff; font-size: 40px; cursor: pointer; z-index: 10; }
	.yr-lightbox-nav { position: absolute; top: 50%; transform: translateY(-50%); color: #fff; font-size: 50px; cursor: pointer; padding: 20px; z-index: 10; }
	.yr-lightbox-prev { left: 20px; }
	.yr-lightbox-next { right: 20px; }
	</style>

	<div id="<?php echo esc_attr( $uid ); ?>" class="yr-masonry-gallery" data-cols="<?php echo $cols; ?>">
		<div class="yr-masonry-grid">
			<?php foreach ( $image_ids as $img_id ) :
				$full = wp_get_attachment_image_url( $img_id, 'full' );
				$medium = wp_get_attachment_image_url( $img_id, 'large' );
				$alt = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
				if ( ! $full ) continue;
			?>
			<div class="yr-gal-item">
				<a href="<?php echo esc_url( $full ); ?>" class="yr-lightbox-trigger">
					<img src="<?php echo esc_url( $medium ); ?>" alt="<?php echo esc_attr( $alt ); ?>" loading="lazy">
					<div class="yr-gal-overlay"><span class="dashicons dashicons-search"></span></div>
				</a>
			</div>
			<?php endforeach; ?>
		</div>
	</div>

	<div id="<?php echo esc_attr( $uid ); ?>-lightbox" class="yr-lightbox">
		<span class="yr-lightbox-close">&times;</span>
		<span class="yr-lightbox-nav yr-lightbox-prev dashicons dashicons-arrow-left-alt2"></span>
		<span class="yr-lightbox-nav yr-lightbox-next dashicons dashicons-arrow-right-alt2"></span>
		<img src="" alt="">
	</div>

	<script>
	(function() {
		var ready = function(fn) { document.readyState !== 'loading' ? fn() : document.addEventListener('DOMContentLoaded', fn); };
		ready(function() {
			var container = document.querySelector('#<?php echo esc_js( $uid ); ?> .yr-masonry-grid');
			if (container && typeof imagesLoaded !== 'undefined' && typeof Masonry !== 'undefined') {
				imagesLoaded(container, function() {
					new Masonry(container, { itemSelector: '.yr-gal-item', percentPosition: true });
				});
			}

			// Lightbox
			var lightbox = document.getElementById('<?php echo esc_js( $uid ); ?>-lightbox');
			var images = document.querySelectorAll('#<?php echo esc_js( $uid ); ?> .yr-lightbox-trigger');
			var current = 0;

			images.forEach(function(img, i) {
				img.addEventListener('click', function(e) {
					e.preventDefault();
					current = i;
					lightbox.querySelector('img').src = this.href;
					lightbox.classList.add('active');
					document.body.style.overflow = 'hidden';
				});
			});

			lightbox.querySelector('.yr-lightbox-close').addEventListener('click', function() {
				lightbox.classList.remove('active');
				document.body.style.overflow = '';
			});

			lightbox.querySelector('.yr-lightbox-prev').addEventListener('click', function(e) {
				e.stopPropagation();
				current = (current - 1 + images.length) % images.length;
				lightbox.querySelector('img').src = images[current].href;
			});

			lightbox.querySelector('.yr-lightbox-next').addEventListener('click', function(e) {
				e.stopPropagation();
				current = (current + 1) % images.length;
				lightbox.querySelector('img').src = images[current].href;
			});

			lightbox.addEventListener('click', function(e) {
				if (e.target === this) {
					this.classList.remove('active');
					document.body.style.overflow = '';
				}
			});

			document.addEventListener('keydown', function(e) {
				if (!lightbox.classList.contains('active')) return;
				if (e.key === 'Escape') lightbox.querySelector('.yr-lightbox-close').click();
				if (e.key === 'ArrowLeft') lightbox.querySelector('.yr-lightbox-prev').click();
				if (e.key === 'ArrowRight') lightbox.querySelector('.yr-lightbox-next').click();
			});
		});
	})();
	</script>
	<?php
	return ob_get_clean();
}

// Flush rewrite rules once
add_action( 'admin_init', 'yr_gallery_flush_rules' );
function yr_gallery_flush_rules() {
	if ( ! get_option( 'yr_gallery_flushed_v2' ) ) {
		flush_rewrite_rules();
		update_option( 'yr_gallery_flushed_v2', true );
	}
}
