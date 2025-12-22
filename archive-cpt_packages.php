<?php
/**
 * The template for displaying Packages Archive
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0
 */

get_header();

?>
<style id="bky-packages-archive-styles">
/* Packages Archive Styles */

.bky-packages-archive-wrapper {
  padding: 60px 0 100px;
  background: #ffffff;
  margin: 0;
  position: relative;
  width: 100%;
  box-sizing: border-box;
}

.bky-packages-archive-container {
  max-width: 1600px;
  width: 100%;
  margin: 0 auto;
  padding: 0 40px;
  box-sizing: border-box;
}

.bky-packages-archive-header {
  text-align: center;
  margin-bottom: 50px;
}

.bky-packages-archive-title {
  font-size: 42px;
  font-weight: 700;
  color: #1a1a1a;
  margin: 0 0 15px 0;
}

.bky-packages-archive-subtitle {
  font-size: 18px;
  color: #666;
  max-width: 600px;
  margin: 0 auto;
}

.bky-packages-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 30px;
  width: 100%;
}

.bky-package-card {
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

.bky-package-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 12px 40px rgba(0,0,0,0.15);
}

.bky-package-image {
  position: relative;
  overflow: hidden;
  aspect-ratio: 16/10;
  background: #f5f5f5;
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
  margin: 0 0 15px 0;
  font-size: 22px;
  font-weight: 600;
  line-height: 1.3;
}

.bky-package-title a {
  color: #1a1a1a;
  text-decoration: none;
  transition: color 0.3s ease;
}

.bky-package-title a:hover {
  color: #C89D4F;
}

.bky-package-excerpt {
  font-size: 15px;
  line-height: 1.6;
  color: #666;
  margin-bottom: 20px;
  flex: 1;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.bky-package-buttons {
  display: flex;
  gap: 12px;
  margin-top: auto;
}

.bky-package-btn {
  flex: 1;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 12px 18px;
  text-align: center;
  font-size: 13px;
  font-weight: 600;
  text-transform: uppercase;
  text-decoration: none;
  border-radius: 10px;
  transition: all 0.25s ease;
  letter-spacing: 0.5px;
  border: none;
  white-space: nowrap;
  min-height: 46px;
  box-sizing: border-box;
}

.bky-package-btn svg {
  width: 17px;
  height: 17px;
  flex-shrink: 0;
}

.bky-package-btn-whatsapp {
  background: #25D366;
  color: #fff;
}

.bky-package-btn-whatsapp:hover {
  background: #1fb855;
  color: #fff;
  transform: translateY(-2px);
}

.bky-package-btn-view {
  background: #A62946;
  color: #fff;
}

.bky-package-btn-view:hover {
  background: #8a2039;
  color: #fff;
  transform: translateY(-2px);
}

/* No packages message */
.bky-no-packages {
  text-align: center;
  padding: 60px 20px;
  color: #666;
  font-size: 18px;
}

/* Responsive */
@media (max-width: 1200px) {
  .bky-package-card {
    flex: 1 1 calc(50% - 15px);
    max-width: calc(50% - 15px);
  }
}

@media (max-width: 768px) {
  .bky-packages-archive-wrapper {
    padding: 40px 0 60px;
  }

  .bky-packages-archive-container {
    padding: 0 20px;
  }

  .bky-packages-archive-title {
    font-size: 32px;
  }

  .bky-package-card {
    flex: 1 1 100%;
    max-width: 100%;
  }

  .bky-packages-grid {
    gap: 20px;
  }

  .bky-package-buttons {
    flex-direction: column;
    gap: 10px;
  }

  .bky-package-btn {
    width: 100%;
  }
}
</style>

<div class="bky-packages-archive-wrapper">
	<div class="bky-packages-archive-container">
		<div class="bky-packages-archive-header">
			<h1 class="bky-packages-archive-title"><?php _e( 'Our Packages', 'yacht-rental' ); ?></h1>
			<p class="bky-packages-archive-subtitle"><?php _e( 'Choose from our exclusive yacht rental packages for unforgettable experiences', 'yacht-rental' ); ?></p>
		</div>

		<?php if ( have_posts() ) : ?>
			<div class="bky-packages-grid">
				<?php while ( have_posts() ) : the_post();
					$whatsapp = get_post_meta( get_the_ID(), '_whatsapp_number', true );
					if ( empty( $whatsapp ) ) {
						$whatsapp = '+971501234567';
					}
					$whatsapp_clean = preg_replace( '/[^0-9]/', '', $whatsapp );
				?>
					<div class="bky-package-card">
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="bky-package-image">
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail( 'large' ); ?>
								</a>
							</div>
						<?php endif; ?>

						<div class="bky-package-content">
							<h2 class="bky-package-title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h2>

							<?php if ( has_excerpt() || get_the_content() ) : ?>
								<div class="bky-package-excerpt">
									<?php echo has_excerpt() ? get_the_excerpt() : wp_trim_words( get_the_content(), 25 ); ?>
								</div>
							<?php endif; ?>

							<div class="bky-package-buttons">
								<a href="https://wa.me/994704043700?text=<?php echo urlencode( 'Hi, I am interested in the ' . get_the_title() . ' package' ); ?>" class="bky-package-btn bky-package-btn-whatsapp" target="_blank">
									<svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
									<?php _e( 'WHATSAPP', 'yacht-rental' ); ?>
								</a>
								<a href="<?php the_permalink(); ?>" class="bky-package-btn bky-package-btn-view">
									<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
									<?php _e( 'VIEW DETAILS', 'yacht-rental' ); ?>
								</a>
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
			) );
			?>

		<?php else : ?>
			<div class="bky-no-packages">
				<p><?php _e( 'No packages found. Please check back later.', 'yacht-rental' ); ?></p>
			</div>
		<?php endif; ?>
	</div>
</div>

<?php
get_footer();
