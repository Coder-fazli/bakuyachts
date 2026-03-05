<?php
/**
 * Founder Section
 *
 * Admin settings page for the founder section + [founder_section] shortcode.
 * Layout: tall image on the left, title + text on the right.
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
add_action( 'admin_menu', 'yr_founder_admin_menu' );
function yr_founder_admin_menu() {
	add_menu_page(
		__( 'Founder Section', 'yacht-rental' ),
		__( 'Founder', 'yacht-rental' ),
		'manage_options',
		'yr-founder',
		'yr_founder_admin_page',
		'dashicons-businessman',
		7
	);
}

// =====================================================
// ADMIN PAGE HTML
// =====================================================
function yr_founder_admin_page() {
	// Save
	if ( isset( $_POST['yr_founder_nonce'] ) && wp_verify_nonce( $_POST['yr_founder_nonce'], 'yr_founder_save' ) ) {
		update_option( 'yr_founder_image_id', intval( $_POST['yr_founder_image_id'] ?? 0 ) );
		update_option( 'yr_founder_subtitle', sanitize_text_field( $_POST['yr_founder_subtitle'] ?? '' ) );
		update_option( 'yr_founder_title', sanitize_text_field( $_POST['yr_founder_title'] ?? '' ) );
		update_option( 'yr_founder_text', wp_kses_post( $_POST['yr_founder_text'] ?? '' ) );
		update_option( 'yr_founder_name', sanitize_text_field( $_POST['yr_founder_name'] ?? '' ) );
		update_option( 'yr_founder_role', sanitize_text_field( $_POST['yr_founder_role'] ?? '' ) );
		echo '<div class="notice notice-success is-dismissible"><p>' . __( 'Founder section saved.', 'yacht-rental' ) . '</p></div>';
	}

	$image_id = get_option( 'yr_founder_image_id', 0 );
	$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'large' ) : '';
	$subtitle  = get_option( 'yr_founder_subtitle', '' );
	$title     = get_option( 'yr_founder_title', '' );
	$text      = get_option( 'yr_founder_text', '' );
	$name      = get_option( 'yr_founder_name', '' );
	$role      = get_option( 'yr_founder_role', '' );

	wp_enqueue_media();
	?>
	<div class="wrap">
		<h1><?php _e( 'Founder Section', 'yacht-rental' ); ?></h1>
		<p class="description"><?php _e( 'Manage the founder section displayed on the homepage via the <code>[founder_section]</code> shortcode.', 'yacht-rental' ); ?></p>

		<form method="post" style="max-width:800px; margin-top:20px;">
			<?php wp_nonce_field( 'yr_founder_save', 'yr_founder_nonce' ); ?>
			<input type="hidden" id="yr-founder-image-id" name="yr_founder_image_id" value="<?php echo esc_attr( $image_id ); ?>">

			<table class="form-table">
				<tr>
					<th scope="row"><label><?php _e( 'Founder Image', 'yacht-rental' ); ?></label></th>
					<td>
						<div id="yr-founder-image-preview" style="margin-bottom:10px;">
							<?php if ( $image_url ) : ?>
								<img src="<?php echo esc_url( $image_url ); ?>" style="max-height:300px; width:auto; display:block; border-radius:8px;">
							<?php endif; ?>
						</div>
						<button type="button" id="yr-upload-founder-image" class="button button-primary">
							<?php _e( 'Upload / Change Image', 'yacht-rental' ); ?>
						</button>
						<?php if ( $image_id ) : ?>
							<button type="button" id="yr-remove-founder-image" class="button" style="margin-left:8px;">
								<?php _e( 'Remove Image', 'yacht-rental' ); ?>
							</button>
						<?php endif; ?>
						<p class="description"><?php _e( 'Recommended: tall/portrait image (e.g. 600×800px).', 'yacht-rental' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="yr-founder-subtitle"><?php _e( 'Subtitle (above title)', 'yacht-rental' ); ?></label></th>
					<td>
						<input type="text" id="yr-founder-subtitle" name="yr_founder_subtitle" value="<?php echo esc_attr( $subtitle ); ?>" class="regular-text" placeholder="e.g. About the Founder">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="yr-founder-title"><?php _e( 'Title', 'yacht-rental' ); ?></label></th>
					<td>
						<input type="text" id="yr-founder-title" name="yr_founder_title" value="<?php echo esc_attr( $title ); ?>" class="regular-text" placeholder="e.g. Passion for the Sea">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="yr-founder-text"><?php _e( 'Description', 'yacht-rental' ); ?></label></th>
					<td>
						<textarea id="yr-founder-text" name="yr_founder_text" rows="8" class="large-text"><?php echo esc_textarea( $text ); ?></textarea>
						<p class="description"><?php _e( 'Basic HTML allowed.', 'yacht-rental' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="yr-founder-name"><?php _e( 'Founder Name', 'yacht-rental' ); ?></label></th>
					<td>
						<input type="text" id="yr-founder-name" name="yr_founder_name" value="<?php echo esc_attr( $name ); ?>" class="regular-text" placeholder="e.g. Anar Mammadov">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="yr-founder-role"><?php _e( 'Role / Title', 'yacht-rental' ); ?></label></th>
					<td>
						<input type="text" id="yr-founder-role" name="yr_founder_role" value="<?php echo esc_attr( $role ); ?>" class="regular-text" placeholder="e.g. Founder & CEO">
					</td>
				</tr>
			</table>

			<?php submit_button( __( 'Save Founder Section', 'yacht-rental' ) ); ?>
		</form>

		<div style="background:#f0f0f0; padding:15px 20px; border-radius:6px; margin-top:25px; display:inline-block;">
			<strong><?php _e( 'Shortcode:', 'yacht-rental' ); ?></strong>
			<code>[founder_section]</code>
			<button type="button" class="button button-small" onclick="navigator.clipboard.writeText('[founder_section]'); this.innerText='Copied!';">
				<?php _e( 'Copy', 'yacht-rental' ); ?>
			</button>
		</div>
	</div>

	<script>
	jQuery(document).ready(function($) {
		var frame;

		$('#yr-upload-founder-image').on('click', function(e) {
			e.preventDefault();
			if (frame) { frame.open(); return; }

			frame = wp.media({
				title: '<?php echo esc_js( __( 'Select Founder Image', 'yacht-rental' ) ); ?>',
				button: { text: '<?php echo esc_js( __( 'Use This Image', 'yacht-rental' ) ); ?>' },
				multiple: false,
				library: { type: 'image' }
			});

			frame.on('select', function() {
				var attachment = frame.state().get('selection').first().toJSON();
				$('#yr-founder-image-id').val(attachment.id);
				var url = attachment.sizes && attachment.sizes.large ? attachment.sizes.large.url : attachment.url;
				$('#yr-founder-image-preview').html('<img src="' + url + '" style="max-height:300px; width:auto; display:block; border-radius:8px;">');
			});

			frame.open();
		});

		$('#yr-remove-founder-image').on('click', function() {
			$('#yr-founder-image-id').val(0);
			$('#yr-founder-image-preview').html('');
		});
	});
	</script>
	<?php
}

// =====================================================
// SHORTCODE: [founder_section]
// =====================================================
add_shortcode( 'founder_section', 'yr_founder_section_shortcode' );
function yr_founder_section_shortcode() {
	$image_id = get_option( 'yr_founder_image_id', 0 );
	$subtitle = get_option( 'yr_founder_subtitle', '' );
	$title    = get_option( 'yr_founder_title', '' );
	$text     = get_option( 'yr_founder_text', '' );
	$name     = get_option( 'yr_founder_name', '' );
	$role     = get_option( 'yr_founder_role', '' );

	if ( empty( $title ) && empty( $image_id ) ) {
		return '';
	}

	$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'large' ) : '';
	$image_alt = $image_id ? get_post_meta( $image_id, '_wp_attachment_image_alt', true ) : esc_attr( $name );

	ob_start();
	?>
<style>
.yr-founder-section {
	padding: 100px 0;
	background: #fff;
	overflow: hidden;
}
.yr-founder-inner {
	max-width: 1200px;
	margin: 0 auto;
	padding: 0 30px;
	display: flex;
	align-items: stretch;
	gap: 80px;
}
.yr-founder-image-wrap {
	flex: 0 0 420px;
	max-width: 420px;
	position: relative;
}
.yr-founder-image-wrap::before {
	content: '';
	position: absolute;
	top: 30px;
	left: -20px;
	width: 100%;
	height: 100%;
	border: 2px solid var(--theme-color, #c9a96e);
	border-radius: 4px;
	z-index: 0;
}
.yr-founder-image-wrap img {
	position: relative;
	z-index: 1;
	width: 100%;
	height: 100%;
	object-fit: cover;
	object-position: top center;
	border-radius: 4px;
	min-height: 560px;
	display: block;
}
.yr-founder-content {
	flex: 1;
	display: flex;
	flex-direction: column;
	justify-content: center;
	padding: 20px 0;
}
.yr-founder-subtitle {
	font-size: 13px;
	font-weight: 600;
	letter-spacing: 3px;
	text-transform: uppercase;
	color: var(--theme-color, #c9a96e);
	margin-bottom: 16px;
	display: block;
}
.yr-founder-title {
	font-size: clamp(28px, 3.5vw, 46px);
	font-weight: 700;
	line-height: 1.15;
	color: #0a0a0a;
	margin: 0 0 28px;
}
.yr-founder-text {
	font-size: 16px;
	line-height: 1.85;
	color: #555;
	margin-bottom: 40px;
}
.yr-founder-text p { margin: 0 0 16px; }
.yr-founder-text p:last-child { margin-bottom: 0; }
.yr-founder-signature {
	display: flex;
	align-items: center;
	gap: 16px;
	padding-top: 32px;
	border-top: 1px solid #e8e8e8;
}
.yr-founder-signature-line {
	width: 40px;
	height: 2px;
	background: var(--theme-color, #c9a96e);
	flex-shrink: 0;
}
.yr-founder-signature-name {
	font-size: 18px;
	font-weight: 700;
	color: #0a0a0a;
	margin: 0;
	line-height: 1.3;
}
.yr-founder-signature-role {
	font-size: 13px;
	color: #888;
	letter-spacing: 1px;
	text-transform: uppercase;
	margin: 4px 0 0;
}
@media (max-width: 1024px) {
	.yr-founder-inner { gap: 50px; }
	.yr-founder-image-wrap { flex: 0 0 340px; max-width: 340px; }
}
@media (max-width: 768px) {
	.yr-founder-section { padding: 60px 0; }
	.yr-founder-inner {
		flex-direction: column;
		gap: 40px;
	}
	.yr-founder-image-wrap {
		flex: none;
		max-width: 100%;
		width: 100%;
	}
	.yr-founder-image-wrap::before { display: none; }
	.yr-founder-image-wrap img { min-height: 380px; }
}
</style>

<section class="yr-founder-section">
	<div class="yr-founder-inner">

		<?php if ( $image_url ) : ?>
		<div class="yr-founder-image-wrap">
			<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>">
		</div>
		<?php endif; ?>

		<div class="yr-founder-content">
			<?php if ( $subtitle ) : ?>
				<span class="yr-founder-subtitle"><?php echo esc_html( $subtitle ); ?></span>
			<?php endif; ?>

			<?php if ( $title ) : ?>
				<h2 class="yr-founder-title"><?php echo esc_html( $title ); ?></h2>
			<?php endif; ?>

			<?php if ( $text ) : ?>
				<div class="yr-founder-text"><?php echo wp_kses_post( wpautop( $text ) ); ?></div>
			<?php endif; ?>

			<?php if ( $name || $role ) : ?>
			<div class="yr-founder-signature">
				<div class="yr-founder-signature-line"></div>
				<div>
					<?php if ( $name ) : ?>
						<p class="yr-founder-signature-name"><?php echo esc_html( $name ); ?></p>
					<?php endif; ?>
					<?php if ( $role ) : ?>
						<p class="yr-founder-signature-role"><?php echo esc_html( $role ); ?></p>
					<?php endif; ?>
				</div>
			</div>
			<?php endif; ?>
		</div>

	</div>
</section>
	<?php
	return ob_get_clean();
}
