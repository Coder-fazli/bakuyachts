<?php
/**
 * The template for displaying Yachts Archive
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0
 */

get_header();

?>
<div class="bky-yacht-archive-wrapper" data-bky-isolated="true">
	<div class="bky-yacht-archive-container">

		<?php if ( have_posts() ) : ?>

			<div class="bky-yacht-archive-grid">

				<?php
				while ( have_posts() ) :
					the_post();

					$yacht_price = get_post_meta( get_the_ID(), '_yr_yacht_price', true );
					$yacht_length = get_post_meta( get_the_ID(), '_yr_yacht_length', true );
					$yacht_cabins = get_post_meta( get_the_ID(), '_yr_yacht_cabins', true );
					$yacht_guests = get_post_meta( get_the_ID(), '_yr_yacht_guests', true );
					$yacht_badge = get_post_meta( get_the_ID(), '_yr_yacht_badge', true );
					?>

					<div class="bky-yacht-card">
						<div class="bky-yacht-card-inner">

							<?php if ( has_post_thumbnail() ) : ?>
								<div class="bky-yacht-image">
									<?php if ( $yacht_badge ) : ?>
										<div class="bky-yacht-badge"><?php echo esc_html( $yacht_badge ); ?></div>
									<?php endif; ?>
									<a href="<?php the_permalink(); ?>">
										<?php 
										$thumbnail_id = get_post_thumbnail_id();
										$image_attrs = array(
											'loading' => 'lazy',
											'decoding' => 'async',
											'alt' => get_the_title(),
										);
										echo wp_get_attachment_image( $thumbnail_id, 'large', false, $image_attrs );
										?>
									</a>
								</div>
							<?php endif; ?>

							<div class="bky-yacht-content">
								<div class="bky-yacht-header">
									<h3 class="bky-yacht-title">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h3>
									<?php if ( $yacht_price ) : ?>
										<div class="bky-yacht-price"><?php echo esc_html( $yacht_price ); ?></div>
									<?php endif; ?>
								</div>

								<div class="bky-yacht-specs">
									<?php if ( $yacht_length ) : ?>
										<span class="bky-yacht-spec">
											<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
											<span><?php echo esc_html( $yacht_length ); ?></span>
										</span>
									<?php endif; ?>

									<?php if ( $yacht_cabins ) : ?>
										<span class="bky-yacht-spec">
											<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="10"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
											<span><?php echo esc_html( $yacht_cabins ); ?> cabins</span>
										</span>
									<?php endif; ?>

									<?php if ( $yacht_guests ) : ?>
										<span class="bky-yacht-spec">
											<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
											<span><?php echo esc_html( $yacht_guests ); ?> Guests</span>
										</span>
									<?php endif; ?>
								</div>

								<?php if ( has_excerpt() || get_the_content() ) : ?>
									<div class="bky-yacht-description">
										<?php echo wp_trim_words( get_the_excerpt() ? get_the_excerpt() : get_the_content(), 20, '...' ); ?>
									</div>
								<?php endif; ?>

								<div class="bky-yacht-buttons">
									<a href="<?php echo esc_url( 'https://wa.me/' ); ?>" class="bky-yacht-btn bky-yacht-btn-whatsapp" target="_blank">
										<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
										WHATSAPP
									</a>
									<a href="<?php the_permalink(); ?>" class="bky-yacht-btn bky-yacht-btn-view">VIEW NOW</a>
								</div>
							</div>

						</div>
					</div>

				<?php endwhile; ?>

			</div>

			<?php
			// Pagination
			the_posts_pagination( array(
				'mid_size'  => 2,
				'prev_text' => __( '&laquo; Previous', 'yacht-rental' ),
				'next_text' => __( 'Next &raquo;', 'yacht-rental' ),
				'class'     => 'bky-yacht-pagination',
			) );
			?>

		<?php else : ?>

			<p><?php _e( 'No yachts found.', 'yacht-rental' ); ?></p>

		<?php endif; ?>

	</div>
</div>

<script>
(function() {
	'use strict';
	// Prevent ThemeREX Addons from affecting yacht archive
	var yachtWrapper = document.querySelector('.bky-yacht-archive-wrapper');
	if (yachtWrapper) {
		// Lock position on load
		var lockPosition = function() {
			var rect = yachtWrapper.getBoundingClientRect();
			yachtWrapper.style.setProperty('position', 'relative', 'important');
			yachtWrapper.style.setProperty('top', '0', 'important');
			yachtWrapper.style.setProperty('left', '0', 'important');
			yachtWrapper.style.setProperty('transform', 'none', 'important');
			yachtWrapper.style.setProperty('margin-top', '0', 'important');
			yachtWrapper.style.setProperty('margin-bottom', '0', 'important');
		};
		
		// Lock on load
		lockPosition();
		
		// Lock on scroll (prevent ThemeREX Addons from moving it)
		var scrollTimeout;
		window.addEventListener('scroll', function() {
			clearTimeout(scrollTimeout);
			scrollTimeout = setTimeout(lockPosition, 10);
		}, { passive: true });
		
		// Lock when body classes change
		var observer = new MutationObserver(function(mutations) {
			mutations.forEach(function(mutation) {
				if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
					lockPosition();
				}
			});
		});
		
		observer.observe(document.body, {
			attributes: true,
			attributeFilter: ['class']
		});
	}
})();
</script>

<?php
get_footer();
