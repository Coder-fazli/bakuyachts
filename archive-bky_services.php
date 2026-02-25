<?php
/**
 * Template for displaying Services Archive
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0
 */

get_header();
?>

<div class="bky-services-wrapper">


<?php if ( have_posts() ) : ?>

	<div class="bky-services-grid">

		<?php while ( have_posts() ) : the_post();
			$post_id          = get_the_ID();
			$icon             = get_post_meta( $post_id, '_service_icon', true );
			$contact_link     = get_post_meta( $post_id, '_service_contact_link', true );
			$contact_btn_text = get_post_meta( $post_id, '_service_contact_btn_text', true );
			$default_btn      = function_exists( 'pll__' ) ? pll__( 'GET IN TOUCH' ) : __( 'GET IN TOUCH', 'yacht-rental' );
			$btn_label        = ! empty( $contact_btn_text ) ? $contact_btn_text : $default_btn;
			$whatsapp_label   = function_exists( 'pll__' ) ? pll__( 'WHATSAPP' ) : __( 'WHATSAPP', 'yacht-rental' );
		?>

		<div class="bky-service-card">
			<div class="bky-service-image">
				<?php if ( has_post_thumbnail() ) : ?>
					<a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail( 'large', array( 'alt' => get_the_title() ) ); ?>
					</a>
				<?php endif; ?>
				<?php if ( $icon ) : ?>
				<div class="bky-service-icon-overlay"><?php echo esc_html( $icon ); ?></div>
				<?php endif; ?>
			</div>

			<div class="bky-service-content">
				<h3 class="bky-service-title">
					<a href="<?php the_permalink(); ?>" style="text-decoration:none;color:inherit;"><?php the_title(); ?></a>
				</h3>
				<p class="bky-service-excerpt"><?php echo wp_trim_words( get_the_excerpt(), 20 ); ?></p>

				<div class="bky-service-buttons">
					<?php if ( ! empty( $contact_link ) ) : ?>
					<a href="<?php echo esc_url( $contact_link ); ?>" class="bky-service-btn bky-service-btn-whatsapp" target="_blank" rel="noopener">
						💬 <?php echo esc_html( $whatsapp_label ); ?>
					</a>
					<?php endif; ?>
					<a href="<?php the_permalink(); ?>" class="bky-service-btn bky-service-btn-view">
						→ <?php echo esc_html( $btn_label ); ?>
					</a>
				</div>
			</div>
		</div>

		<?php endwhile; ?>

	</div><!-- /.bky-services-grid -->

	<?php else : ?>
		<p><?php _e( 'No services found.', 'yacht-rental' ); ?></p>
	<?php endif; ?>

</div><!-- /.bky-services-wrapper -->

<?php get_footer(); ?>
