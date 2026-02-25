<?php
/**
 * Template for displaying Single Service
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0
 */

$post_id            = get_the_ID();
$head_description   = get_post_meta( $post_id, '_service_head_description', true );
$bottom_description = get_post_meta( $post_id, '_service_bottom_description', true );
$features_raw       = get_post_meta( $post_id, '_service_features', true );
$contact_link       = get_post_meta( $post_id, '_service_contact_link', true );
$contact_btn_text   = get_post_meta( $post_id, '_service_contact_btn_text', true );
$service_faq        = get_post_meta( $post_id, '_service_faq', true );
if ( ! is_array( $service_faq ) ) $service_faq = array();

$features = array();
if ( ! empty( $features_raw ) ) {
	$features = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', $features_raw ) ) );
}

$default_btn    = function_exists( 'pll__' ) ? pll__( 'GET IN TOUCH' ) : __( 'GET IN TOUCH', 'yacht-rental' );
$btn_label      = ! empty( $contact_btn_text ) ? $contact_btn_text : $default_btn;
$whatsapp_label = function_exists( 'pll__' ) ? pll__( 'WHATSAPP' ) : __( 'WHATSAPP', 'yacht-rental' );

get_header();
?>

<div class="service-single-container">

	<!-- Breadcrumbs -->
	<div class="service-breadcrumbs">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php _e( 'Home', 'yacht-rental' ); ?></a>
		<span class="sep">◆</span>
		<a href="<?php echo esc_url( get_post_type_archive_link( 'bky_services' ) ); ?>"><?php _e( 'Services', 'yacht-rental' ); ?></a>
		<span class="sep">◆</span>
		<?php the_title(); ?>
	</div>

	<!-- Hero Split -->
	<div class="service-hero">
		<div class="service-hero-image">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'large', array( 'alt' => get_the_title() ) ); ?>
			<?php endif; ?>
		</div>

		<div class="service-hero-content">
			<span class="service-category-badge"><?php _e( 'Service', 'yacht-rental' ); ?></span>
			<h1 class="service-single-title"><?php the_title(); ?></h1>

			<?php if ( ! empty( $head_description ) ) : ?>
			<div class="service-head-description"><?php echo wp_kses_post( $head_description ); ?></div>
			<?php endif; ?>

			<?php if ( ! empty( $features ) ) : ?>
			<div class="service-features">
				<h3><?php _e( 'What\'s included', 'yacht-rental' ); ?></h3>
				<ul class="service-features-list">
					<?php foreach ( $features as $feature ) : ?>
					<li><?php echo esc_html( $feature ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<?php endif; ?>

			<div class="service-cta">
				<?php if ( ! empty( $contact_link ) ) : ?>
				<a href="<?php echo esc_url( $contact_link ); ?>" class="service-btn-contact" target="_blank" rel="noopener">
					✈ <?php echo esc_html( $btn_label ); ?>
				</a>
				<a href="<?php echo esc_url( $contact_link ); ?>" class="service-btn-whatsapp-single" target="_blank" rel="noopener">
					💬 <?php echo esc_html( $whatsapp_label ); ?>
				</a>
				<?php endif; ?>
			</div>
		</div>
	</div><!-- /.service-hero -->

	<?php if ( ! empty( $bottom_description ) ) : ?>
	<div class="service-bottom-section">
		<h2><?php _e( 'About This Service', 'yacht-rental' ); ?></h2>
		<div class="service-accent-line"></div>
		<div class="service-bottom-content"><?php echo wp_kses_post( $bottom_description ); ?></div>
	</div>
	<?php endif; ?>

	<?php if ( ! empty( $service_faq ) ) : ?>
	<div class="service-faq-section">
		<h2><?php _e( 'Frequently Asked Questions', 'yacht-rental' ); ?></h2>
		<div class="service-accent-line"></div>

		<?php foreach ( $service_faq as $faq ) :
			if ( empty( $faq['question'] ) ) continue;
		?>
		<div class="service-faq-item">
			<div class="service-faq-question">
				<?php echo esc_html( $faq['question'] ); ?>
				<span class="faq-toggle">+</span>
			</div>
			<div class="service-faq-answer"><?php echo esc_html( $faq['answer'] ?? '' ); ?></div>
		</div>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>

</div><!-- /.service-single-container -->

<script>
(function() {
	document.querySelectorAll('.service-faq-question').forEach(function(q) {
		q.addEventListener('click', function() {
			this.closest('.service-faq-item').classList.toggle('open');
		});
	});
})();
</script>

<?php get_footer(); ?>
