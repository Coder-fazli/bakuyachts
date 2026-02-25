<?php
/**
 * Partners Slider
 *
 * Admin page to upload partner logos + [partners_slider] shortcode.
 * Simple gallery-style upload — no posts, no titles, just logos.
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// =====================================================
// ADMIN MENU PAGE
// =====================================================
add_action( 'admin_menu', 'yr_partners_admin_menu' );
function yr_partners_admin_menu() {
	add_menu_page(
		__( 'Partners', 'yacht-rental' ),
		__( 'Partners', 'yacht-rental' ),
		'manage_options',
		'yr-partners',
		'yr_partners_admin_page',
		'dashicons-groups',
		6
	);
}

// =====================================================
// ADMIN PAGE HTML
// =====================================================
function yr_partners_admin_page() {
	// Save
	if ( isset( $_POST['yr_partners_nonce'] ) && wp_verify_nonce( $_POST['yr_partners_nonce'], 'yr_partners_save' ) ) {
		$logo_ids = isset( $_POST['yr_partner_logos'] ) ? sanitize_text_field( $_POST['yr_partner_logos'] ) : '';
		update_option( 'yr_partner_logos', $logo_ids );
		echo '<div class="notice notice-success is-dismissible"><p>' . __( 'Partners saved.', 'yacht-rental' ) . '</p></div>';
	}

	$logo_ids = get_option( 'yr_partner_logos', '' );

	wp_enqueue_media();
	?>
	<div class="wrap">
		<h1><?php _e( 'Partner Logos', 'yacht-rental' ); ?></h1>
		<p class="description"><?php _e( 'Upload partner logos here. They will appear in the scrolling carousel via the <code>[partners_slider]</code> shortcode.', 'yacht-rental' ); ?></p>

		<form method="post">
			<?php wp_nonce_field( 'yr_partners_save', 'yr_partners_nonce' ); ?>
			<input type="hidden" id="yr-partner-ids" name="yr_partner_logos" value="<?php echo esc_attr( $logo_ids ); ?>">

			<style>
				#yr-partner-preview { display: flex; flex-wrap: wrap; gap: 15px; margin: 20px 0; }
				#yr-partner-preview .yr-logo-item { position: relative; width: 160px; height: 100px; background: #f9f9f9; border: 2px solid #ddd; border-radius: 8px; display: flex; align-items: center; justify-content: center; padding: 10px; }
				#yr-partner-preview .yr-logo-item img { max-width: 100%; max-height: 100%; object-fit: contain; }
				#yr-partner-preview .yr-logo-item:hover { border-color: #0073aa; }
				#yr-partner-preview .yr-logo-remove { position: absolute; top: -8px; right: -8px; background: #dc3232; color: #fff; border: none; border-radius: 50%; width: 24px; height: 24px; cursor: pointer; font-size: 16px; line-height: 22px; }
				#yr-partner-preview .yr-logo-remove:hover { background: #a00; }
				.yr-shortcode-info { background: #f0f0f0; padding: 15px 20px; border-radius: 6px; margin-top: 25px; display: inline-block; }
				.yr-shortcode-info code { background: #fff; padding: 6px 12px; font-size: 14px; border-radius: 3px; }
			</style>

			<div id="yr-partner-preview">
				<?php
				if ( ! empty( $logo_ids ) ) {
					$ids = array_filter( array_map( 'intval', explode( ',', $logo_ids ) ) );
					foreach ( $ids as $id ) {
						$url = wp_get_attachment_image_url( $id, 'medium' );
						if ( $url ) {
							echo '<div class="yr-logo-item" data-id="' . esc_attr( $id ) . '">';
							echo '<img src="' . esc_url( $url ) . '" alt="">';
							echo '<button type="button" class="yr-logo-remove">&times;</button>';
							echo '</div>';
						}
					}
				}
				?>
			</div>

			<p>
				<button type="button" id="yr-upload-logos" class="button button-primary button-large">
					<span class="dashicons dashicons-upload" style="vertical-align: middle; margin-right: 5px;"></span>
					<?php _e( 'Upload Logos', 'yacht-rental' ); ?>
				</button>
				<button type="button" id="yr-clear-logos" class="button" style="margin-left: 10px;">
					<?php _e( 'Clear All', 'yacht-rental' ); ?>
				</button>
			</p>

			<?php submit_button( __( 'Save Partners', 'yacht-rental' ) ); ?>
		</form>

		<div class="yr-shortcode-info">
			<strong><?php _e( 'Shortcode:', 'yacht-rental' ); ?></strong>
			<code>[partners_slider]</code>
			<button type="button" class="button button-small" onclick="navigator.clipboard.writeText('[partners_slider]'); this.innerText='Copied!';">
				<?php _e( 'Copy', 'yacht-rental' ); ?>
			</button>
		</div>
	</div>

	<script>
	jQuery(document).ready(function($) {
		var frame;

		$('#yr-upload-logos').on('click', function(e) {
			e.preventDefault();

			if (frame) {
				frame.open();
				return;
			}

			frame = wp.media({
				title: '<?php echo esc_js( __( 'Select Partner Logos', 'yacht-rental' ) ); ?>',
				button: { text: '<?php echo esc_js( __( 'Add Logos', 'yacht-rental' ) ); ?>' },
				multiple: true,
				library: { type: 'image' }
			});

			frame.on('select', function() {
				var selection = frame.state().get('selection');
				var ids = $('#yr-partner-ids').val() ? $('#yr-partner-ids').val().split(',') : [];

				selection.each(function(attachment) {
					var id = String(attachment.id);
					if (ids.indexOf(id) === -1) {
						ids.push(id);
						var url = attachment.attributes.sizes && attachment.attributes.sizes.medium
							? attachment.attributes.sizes.medium.url
							: attachment.attributes.url;
						$('#yr-partner-preview').append(
							'<div class="yr-logo-item" data-id="' + id + '">' +
							'<img src="' + url + '" alt="">' +
							'<button type="button" class="yr-logo-remove">&times;</button>' +
							'</div>'
						);
					}
				});

				$('#yr-partner-ids').val(ids.join(','));
			});

			frame.open();
		});

		$(document).on('click', '.yr-logo-remove', function() {
			var $item = $(this).closest('.yr-logo-item');
			var id = String($item.data('id'));
			var ids = $('#yr-partner-ids').val().split(',').filter(function(i) { return i != id; });
			$('#yr-partner-ids').val(ids.join(','));
			$item.remove();
		});

		$('#yr-clear-logos').on('click', function() {
			if (confirm('<?php echo esc_js( __( 'Remove all logos?', 'yacht-rental' ) ); ?>')) {
				$('#yr-partner-preview').empty();
				$('#yr-partner-ids').val('');
			}
		});
	});
	</script>
	<?php
}

// =====================================================
// SHORTCODE: [partners_slider]
// =====================================================
add_shortcode( 'partners_slider', 'yr_partners_slider_shortcode' );
function yr_partners_slider_shortcode( $atts ) {
	$logo_ids_str = get_option( 'yr_partner_logos', '' );
	if ( empty( $logo_ids_str ) ) {
		return '';
	}

	$logo_ids = array_filter( array_map( 'intval', explode( ',', $logo_ids_str ) ) );
	if ( empty( $logo_ids ) ) {
		return '';
	}

	ob_start();
	?>
<style>
.yr-partners-container {
	max-width: 100%;
	margin: 0 auto;
	overflow: hidden;
}
.yr-partner-track {
	display: flex;
	width: max-content;
	animation: yr-scroll 20s linear infinite;
}
.yr-partner-track:hover {
	animation-play-state: paused;
}
.yr-partner-track .yr-animate-scroll {
	display: flex;
	align-items: center;
	gap: 60px;
	padding-right: 60px;
}
.yr-partner-logo {
	max-height: 90px;
	width: auto;
	min-width: 120px;
	object-fit: contain;
	opacity: 0.7;
	filter: grayscale(100%);
	transition: all 0.3s ease;
	flex-shrink: 0;
}
.yr-partner-logo:hover {
	opacity: 1;
	filter: grayscale(0);
}
@keyframes yr-scroll {
	0% { transform: translateX(0); }
	100% { transform: translateX(-50%); }
}
@media (max-width: 768px) {
	.yr-partner-track .yr-animate-scroll {
		gap: 40px;
		padding-right: 40px;
	}
	.yr-partner-logo {
		max-height: 60px;
		min-width: 90px;
	}
}
</style>

<section class="yr-partners-section" style="background:#fff;padding:3rem 0;">
	<div class="yr-partners-container">
		<div class="yr-partner-track">
			<div class="yr-animate-scroll">
				<?php foreach ( $logo_ids as $id ) :
					$url = wp_get_attachment_image_url( $id, 'medium' );
					$alt = get_post_meta( $id, '_wp_attachment_image_alt', true );
					if ( ! $url ) continue;
				?>
					<img src="<?php echo esc_url( $url ); ?>" alt="<?php echo esc_attr( $alt ); ?>" class="yr-partner-logo">
				<?php endforeach; ?>
			</div>
			<div class="yr-animate-scroll" aria-hidden="true">
				<?php foreach ( $logo_ids as $id ) :
					$url = wp_get_attachment_image_url( $id, 'medium' );
					$alt = get_post_meta( $id, '_wp_attachment_image_alt', true );
					if ( ! $url ) continue;
				?>
					<img src="<?php echo esc_url( $url ); ?>" alt="<?php echo esc_attr( $alt ); ?>" class="yr-partner-logo">
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
	<?php
	return ob_get_clean();
}
