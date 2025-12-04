<?php
/**
 * The template for displaying Yachts Archive
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0
 */

get_header();

?>
<div class="yr_yachts_archive_wrapper">
	<div class="yr_yachts_container">

		<?php if ( have_posts() ) : ?>

			<div class="yr_yachts_grid">

				<?php
				while ( have_posts() ) :
					the_post();

					$yacht_price = get_post_meta( get_the_ID(), '_yr_yacht_price', true );
					$yacht_length = get_post_meta( get_the_ID(), '_yr_yacht_length', true );
					$yacht_cabins = get_post_meta( get_the_ID(), '_yr_yacht_cabins', true );
					$yacht_guests = get_post_meta( get_the_ID(), '_yr_yacht_guests', true );
					$yacht_badge = get_post_meta( get_the_ID(), '_yr_yacht_badge', true );
					?>

					<div class="yr_yacht_card">
						<div class="yr_yacht_card_inner">

							<?php if ( $yacht_badge ) : ?>
								<div class="yr_yacht_badge"><?php echo esc_html( $yacht_badge ); ?></div>
							<?php endif; ?>

							<?php if ( has_post_thumbnail() ) : ?>
								<div class="yr_yacht_image">
									<a href="<?php the_permalink(); ?>">
										<?php the_post_thumbnail( 'medium_large' ); ?>
									</a>
								</div>
							<?php endif; ?>

							<?php if ( $yacht_price ) : ?>
								<div class="yr_yacht_price_top"><?php echo esc_html( $yacht_price ); ?></div>
							<?php endif; ?>

							<div class="yr_yacht_content">
								<h3 class="yr_yacht_title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h3>

								<div class="yr_yacht_specs">
									<?php if ( $yacht_length ) : ?>
										<span class="yr_yacht_spec">
											<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M3 17v2h6v-2H3zM3 5v2h10V5H3zm10 16v-2h8v-2h-8v-2h-2v6h2zM7 9v2H3v2h4v2h2V9H7zm14 4v-2H11v2h10zm-6-4h2V7h4V5h-4V3h-2v6z"/></svg>
											<?php echo esc_html( $yacht_length ); ?>
										</span>
									<?php endif; ?>

									<?php if ( $yacht_cabins ) : ?>
										<span class="yr_yacht_spec">
											<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M19 9.3V4h-3v2.6L12 3L2 12h3v8h5v-6h4v6h5v-8h3l-3-2.7zm-9 .7c0-1.1.9-2 2-2s2 .9 2 2h-4z"/></svg>
											<?php echo esc_html( $yacht_cabins ); ?> cabins
										</span>
									<?php endif; ?>

									<?php if ( $yacht_guests ) : ?>
										<span class="yr_yacht_spec">
											<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
											<?php echo esc_html( $yacht_guests ); ?> Guests
										</span>
									<?php endif; ?>
								</div>

								<div class="yr_yacht_buttons">
									<a href="<?php echo esc_url( 'https://wa.me/' ); ?>" class="yr_yacht_btn yr_yacht_btn_whatsapp" target="_blank">WHATSAPP</a>
									<a href="<?php the_permalink(); ?>" class="yr_yacht_btn yr_yacht_btn_view">VIEW NOW</a>
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
				'class'     => 'yr_yachts_pagination',
			) );
			?>

		<?php else : ?>

			<p><?php _e( 'No yachts found.', 'yacht-rental' ); ?></p>

		<?php endif; ?>

	</div>
</div>

<?php
get_footer();
