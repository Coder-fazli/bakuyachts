<?php
/**
 * The template for displaying Yachts Archive
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0
 */

get_header();

?>
<style id="bky-yacht-archive-styles">
/* Yacht Archive Styles - Completely isolated from ThemeREX Addons */

/* Prevent trx_addons_page_scrolled class from affecting yacht archive content */
body.trx_addons_page_scrolled .bky-yacht-archive-wrapper *,
body.trx_addons_scroll_to_top_show .bky-yacht-archive-wrapper * {
  animation: none !important;
  transition: none !important;
  transform: none !important;
  opacity: 1 !important;
  visibility: visible !important;
}

/* Force disable scroll-based animations only in the yacht archive content area */
/* Preserve header/menu functionality by not applying to header elements */
.bky-yacht-archive-wrapper * {
  animation: none !important;
  transition: none !important;
  transform: none !important;
}

/* Allow only specific, controlled transitions on our yacht cards */
.bky-yacht-card,
.bky-yacht-image img,
.bky-yacht-btn,
.bky-yacht-title a {
  transition: all 0.3s ease !important;
}

/* Prevent any scroll-triggered transforms or opacity changes */
body.post-type-archive-cpt_yachts .bky-yacht-archive-wrapper .bky-yacht-card,
body.trx_addons_page_scrolled .bky-yacht-archive-wrapper .bky-yacht-card,
body.trx_addons_scroll_to_top_show .bky-yacht-archive-wrapper .bky-yacht-card {
  transform: none !important;
  opacity: 1 !important;
  visibility: visible !important;
}

/* Disable any Elementor animations within yacht archive content only */
.bky-yacht-archive-wrapper .elementor-invisible {
  opacity: 1 !important;
  visibility: visible !important;
}

/* Disable ThemeREX animations within yacht archive content only */
.bky-yacht-archive-wrapper [data-animation],
.bky-yacht-archive-wrapper .sc_parallax,
.bky-yacht-archive-wrapper .parallax_wrap {
  animation: none !important;
  transform: none !important;
}

/* Prevent layout shifts caused by header changes during scroll */
body.post-type-archive-cpt_yachts {
  /* Lock the layout to prevent content jumps when header becomes fixed */
  overflow-x: hidden;
}

/* Fix the huge space caused by top_panel full height */
body.post-type-archive-cpt_yachts .top_panel,
body.post-type-archive-cpt_yachts .top_panel_default,
body.post-type-archive-cpt_yachts .header_fullheight,
body.post-type-archive-cpt_yachts .yacht-rental-full-height {
  height: auto !important;
  min-height: auto !important;
  max-height: none !important;
  padding-top: 0 !important;
  padding-bottom: 0 !important;
}

/* Reduce the huge gap between page title and yacht cards */
body.post-type-archive-cpt_yachts .page_content_wrap {
  padding-top: 0 !important;
  margin-top: 0 !important;
}

body.post-type-archive-cpt_yachts .content_wrap {
  padding-top: 0 !important;
  margin-top: 0 !important;
}

/* Reduce page header/breadcrumb spacing */
body.post-type-archive-cpt_yachts .top_panel_title,
body.post-type-archive-cpt_yachts .sc_layouts_title {
  padding-top: 60px !important;
  padding-bottom: 40px !important;
  min-height: auto !important;
  height: auto !important;
}

body.post-type-archive-cpt_yachts .sc_layouts_title_content {
  padding-top: 0 !important;
  padding-bottom: 0 !important;
}

/* Add dropdown arrows for menu items with submenus */
body.post-type-archive-cpt_yachts .menu-item-has-children > a:after,
body.post-type-archive-cpt_yachts .sc_layouts_menu_nav > li.menu-item-has-children > a:after {
  content: '\e828' !important; /* icon-down from fontello */
  font-family: 'fontello' !important;
  margin-left: 6px;
  font-size: 10px;
  opacity: 0.7;
  display: inline-block !important;
  vertical-align: middle;
  font-weight: normal !important;
  speak: none;
  font-style: normal;
  font-variant: normal;
  text-transform: none;
  line-height: 1;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

/* Show submenu indicator on hover */
body.post-type-archive-cpt_yachts .menu-item-has-children:hover > a:after {
  opacity: 1;
}

/* Ensure yacht archive wrapper maintains stable position */
.bky-yacht-archive-wrapper {
  padding: 0 0 100px;
  background: #ffffff;
  margin: 0;
  margin-top: -60px !important;
  position: relative;
  width: 100%;
  box-sizing: border-box;
  display: block;
  /* Prevent any layout shifts */
  will-change: auto;
  contain: layout style;
}

.bky-yacht-archive-container {
  max-width: 1400px;
  margin: 0 auto;
  padding: 0 30px;
  display: block;
}

.bky-yacht-archive-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 40px;
  margin-bottom: 60px;
  width: 100%;
}


.bky-yacht-card {
  background: #fff;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 2px 12px rgba(0,0,0,0.08);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  display: block;
  width: 100%;
  position: relative;
}

.bky-yacht-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 6px 24px rgba(0,0,0,0.12);
}

.bky-yacht-card-inner {
  display: flex;
  flex-direction: column;
  height: 100%;
}

.bky-yacht-image {
  position: relative;
  overflow: hidden;
  aspect-ratio: 4/3;
  background: #f5f5f5;
  display: block;
  width: 100%;
}

.bky-yacht-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.5s ease;
  display: block;
}

.bky-yacht-card:hover .bky-yacht-image img {
  transform: scale(1.05);
}

.bky-yacht-badge {
  position: absolute;
  top: 20px;
  left: 20px;
  background: #ff6b6b;
  color: #fff;
  padding: 8px 16px;
  font-size: 10px;
  font-weight: 600;
  text-transform: uppercase;
  border-radius: 8px;
  z-index: 10;
  letter-spacing: 1px;
}

.bky-yacht-content {
  padding: 25px;
  flex: 1;
  display: flex;
  flex-direction: column;
}

.bky-yacht-title {
  margin: 0 0 15px 0;
  font-size: 22px;
  font-weight: 600;
  line-height: 1.3;
}

.bky-yacht-title a {
  color: #1a1a1a;
  text-decoration: none;
  transition: color 0.3s ease;
}

.bky-yacht-title a:hover {
  color: #C89D4F;
}

.bky-yacht-specs {
  display: flex;
  flex-wrap: wrap;
  gap: 12px;
  margin-bottom: 20px;
  padding-bottom: 20px;
  border-bottom: 1px solid #e8e8e8;
}

.bky-yacht-spec {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 13px;
  color: #555;
  font-weight: 400;
  background: #f8f8f8;
  padding: 7px 12px;
  border-radius: 8px;
  white-space: nowrap;
}

.bky-yacht-spec svg {
  width: 16px;
  height: 16px;
  flex-shrink: 0;
  color: #888;
  stroke-width: 2;
}

.bky-yacht-description {
  font-size: 15px;
  line-height: 1.65;
  color: #6a6a6a;
  margin-bottom: 24px;
  flex: 1;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.bky-yacht-buttons {
  display: flex;
  gap: 14px;
  margin-top: auto;
}

.bky-yacht-btn {
  flex: 1;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 14px 22px;
  text-align: center;
  font-size: 13px;
  font-weight: 600;
  text-transform: uppercase;
  text-decoration: none;
  border-radius: 10px;
  transition: all 0.25s ease;
  letter-spacing: 0.5px;
  border: none;
}

.bky-yacht-btn svg {
  width: 17px;
  height: 17px;
  flex-shrink: 0;
}

.bky-yacht-btn-whatsapp {
  background: #25D366;
  color: #fff;
}

.bky-yacht-btn-whatsapp:hover {
  background: #1ebc59;
  box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
}

.bky-yacht-btn-view {
  background: #A62946;
  color: #fff;
}

.bky-yacht-btn-view:hover {
  background: #8B1F39;
  box-shadow: 0 4px 12px rgba(166, 41, 70, 0.3);
}

.bky-yacht-pagination {
  margin-top: 50px;
  text-align: center;
}

@media (max-width: 1199px) {
  .bky-yacht-archive-container {
    max-width: 1100px;
    padding: 0 25px;
  }
  .bky-yacht-archive-grid {
    gap: 35px;
  }
  .bky-yacht-title {
    font-size: 21px;
  }
}

@media (max-width: 991px) {
  .bky-yacht-archive-grid {
    grid-template-columns: repeat(2, 1fr);
    gap: 30px;
  }
  .bky-yacht-title {
    font-size: 20px;
  }
  .bky-yacht-content {
    padding: 24px;
  }
}

@media (max-width: 767px) {
  .bky-yacht-archive-wrapper {
    padding: 50px 0 60px;
  }
  .bky-yacht-archive-container {
    padding: 0 20px;
  }
  .bky-yacht-archive-grid {
    grid-template-columns: 1fr;
    gap: 24px;
  }
  .bky-yacht-content {
    padding: 22px;
  }
  .bky-yacht-title {
    font-size: 19px;
  }
  .bky-yacht-buttons {
    flex-direction: column;
    gap: 10px;
  }
  .bky-yacht-btn {
    width: 100%;
  }
}
</style>

<div class="bky-yacht-archive-wrapper">
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
								<h3 class="bky-yacht-title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h3>

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
									<a href="<?php the_permalink(); ?>" class="bky-yacht-btn bky-yacht-btn-view">
										<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
										VIEW DETAILS
									</a>
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

	// Minimal menu functionality for yacht archive page (since we disabled ThemeREX Addons)
	if (document.body.classList.contains('post-type-archive-cpt_yachts')) {

		// Mobile menu toggle
		document.addEventListener('DOMContentLoaded', function() {
			var menuToggle = document.querySelector('.menu_mobile_button, .sc_layouts_menu_mobile_button');
			var mobileMenu = document.querySelector('.menu_mobile, .sc_layouts_menu_mobile');

			if (menuToggle && mobileMenu) {
				menuToggle.addEventListener('click', function(e) {
					e.preventDefault();
					mobileMenu.classList.toggle('opened');
					document.body.classList.toggle('menu_mobile_opened');
				});
			}

			// Close mobile menu when clicking outside
			document.addEventListener('click', function(e) {
				if (mobileMenu && mobileMenu.classList.contains('opened')) {
					if (!mobileMenu.contains(e.target) && !menuToggle.contains(e.target)) {
						mobileMenu.classList.remove('opened');
						document.body.classList.remove('menu_mobile_opened');
					}
				}
			});
		});
	}
})();
</script>

<?php
get_footer();
