<?php
/**
 * Single Package Template
 * Matches yacht template structure
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0
 */

// Get post data
if ( have_posts() ) {
	the_post();
}

// Get custom fields
$package_title = get_post_meta( get_the_ID(), '_package_title', true );
$package_features = get_post_meta( get_the_ID(), '_package_features', true );
$whatsapp_number = get_post_meta( get_the_ID(), '_whatsapp_number', true );
$button_link = get_post_meta( get_the_ID(), '_button_link', true );

// Convert features textarea to array
$features_array = array_filter( array_map( 'trim', explode( "\n", $package_features ) ) );

// Generate button link
$contact_link = '';
if ( ! empty( $button_link ) ) {
	$contact_link = esc_url( $button_link );
} elseif ( ! empty( $whatsapp_number ) ) {
	$clean_number = preg_replace( '/[^0-9+]/', '', $whatsapp_number );
	$contact_link = 'https://wa.me/' . ltrim( $clean_number, '+' );
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js<?php echo ' scheme_' . esc_attr( yacht_rental_get_theme_option( 'color_scheme' ) ); ?>">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

	<style>
		/* Package-specific styles */
		.package-page-wrap {
			max-width: 1200px;
			margin: 0 auto;
			padding: 0 20px;
		}

		/* Breadcrumb Styles */
		.package-breadcrumb {
			padding: 8px 0;
			background: linear-gradient(135deg, #EEF7FD 0%, #E6F3FA 100%);
			border-bottom: 1px solid rgba(110, 193, 228, 0.1);
		}

		.breadcrumb-nav {
			display: flex;
			align-items: center;
			gap: 8px;
			font-size: 12px;
		}

		.breadcrumb-item {
			color: #7A7A7A;
			text-decoration: none;
			transition: all 0.3s ease;
		}

		.breadcrumb-item:hover {
			color: #6EC1E4;
		}

		.breadcrumb-item.active {
			color: #050C29;
			font-weight: 500;
		}

		.breadcrumb-separator {
			width: 5px;
			height: 5px;
			background-color: #7A7A7A;
			border-radius: 50%;
			opacity: 0.6;
		}

		/* Main Section */
		.package-main-section {
			background-color: #fff;
			padding: 15px 0 10px;
		}

		.package-header {
			text-align: center;
			margin-bottom: 15px;
		}

		.package-header h1 {
			font-size: 34px;
			font-weight: 700;
			color: #050C29;
			margin-bottom: 8px;
			line-height: 1.2;
			letter-spacing: -0.5px;
		}

		.package-subtitle {
			font-size: 16px;
			color: #7A7A7A;
			font-weight: 500;
			margin-bottom: 12px;
			letter-spacing: 0.3px;
		}

		.package-intro-text {
			max-width: 700px;
			margin: 0 auto;
			color: #54595F;
			font-size: 14px;
			line-height: 1.6;
		}

		/* Package Section */
		.package-section {
			display: grid;
			grid-template-columns: 50% 50%;
			gap: 40px;
			align-items: stretch;
			margin-top: 15px;
		}

		.package-image {
			position: relative;
			min-height: 100%;
			border-radius: 8px;
			overflow: hidden;
			box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
		}

		.package-image img {
			width: 100%;
			height: 100%;
			display: block;
			object-fit: cover;
			object-position: center;
		}

		.package-content {
			display: flex;
			flex-direction: column;
			justify-content: center;
			padding: 0;
		}

		.package-content h2 {
			font-size: 24px;
			font-weight: 700;
			color: #050C29;
			margin-bottom: 12px;
			line-height: 1.3;
			letter-spacing: -0.3px;
		}

		.features-list {
			list-style: none;
			margin-bottom: 15px;
		}

		.features-list li {
			padding: 3px 0;
			color: #54595F;
			font-size: 13px;
			display: flex;
			align-items: flex-start;
			gap: 10px;
			transition: all 0.2s ease;
		}

		.features-list li:hover {
			transform: translateX(3px);
		}

		.features-list li::before {
			content: "✓";
			color: #61CE70;
			font-weight: 700;
			font-size: 16px;
			flex-shrink: 0;
			margin-top: 1px;
		}

		/* Buttons */
		.btn-red {
			background: linear-gradient(135deg, #BC1833 0%, #D41F3D 100%);
			color: #fff;
			display: inline-flex;
			align-items: center;
			justify-content: center;
			gap: 8px;
			padding: 10px 30px;
			font-size: 12px;
			font-weight: 600;
			text-decoration: none;
			border-radius: 50px;
			transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
			border: none;
			cursor: pointer;
			text-align: center;
			letter-spacing: 0.8px;
			text-transform: uppercase;
			position: relative;
			overflow: hidden;
			box-shadow: 0 4px 15px rgba(188, 24, 51, 0.3);
		}

		.btn-red::before {
			content: '';
			position: absolute;
			top: 50%;
			left: 50%;
			width: 0;
			height: 0;
			border-radius: 50%;
			background: rgba(255, 255, 255, 0.15);
			transform: translate(-50%, -50%);
			transition: width 0.6s, height 0.6s;
		}

		.btn-red:hover::before {
			width: 300px;
			height: 300px;
		}

		.btn-red:hover {
			transform: translateY(-3px);
			box-shadow: 0 7px 20px rgba(188, 24, 51, 0.45);
		}

		.btn-red::after {
			content: "✈";
			font-size: 16px;
			transform: rotate(45deg);
			display: inline-block;
			transition: transform 0.3s ease;
		}

		.btn-red:hover::after {
			transform: rotate(45deg) translateX(3px);
		}

		/* FAQ Section */
		.package-faq-section {
			background: linear-gradient(180deg, #fff 0%, #fafbfc 100%);
			padding: 15px 0 10px;
		}

		.faq-title {
			text-align: center;
			font-size: 24px;
			font-weight: 700;
			color: #050C29;
			margin-bottom: 15px;
			font-family: 'Georgia', serif;
			letter-spacing: -0.5px;
		}

		.faq-container {
			max-width: 900px;
			margin: 0 auto;
		}

		.faq-item {
			background-color: #fff;
			border-radius: 8px;
			overflow: hidden;
			transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
			box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
			border: 1px solid #f0f0f0;
			margin-bottom: 10px;
		}

		.faq-item:hover {
			box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
			transform: translateY(-2px);
		}

		.faq-question {
			padding: 12px 18px;
			cursor: pointer;
			display: flex;
			justify-content: space-between;
			align-items: center;
			gap: 12px;
			transition: all 0.3s;
		}

		.faq-question h3 {
			font-size: 14px;
			font-weight: 600;
			color: #61CE70;
			margin: 0;
			flex: 1;
			transition: color 0.3s;
		}

		.faq-item:hover .faq-question h3 {
			color: #4FB85E;
		}

		.faq-toggle {
			color: #61CE70;
			font-size: 20px;
			font-weight: 300;
			transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1), color 0.3s;
			flex-shrink: 0;
			width: 24px;
			height: 24px;
			display: flex;
			align-items: center;
			justify-content: center;
		}

		.faq-item.active .faq-toggle {
			transform: rotate(45deg);
			color: #4FB85E;
		}

		.faq-answer {
			max-height: 0;
			overflow: hidden;
			transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1), padding 0.4s ease;
		}

		.faq-item.active .faq-answer {
			max-height: 350px;
			padding: 0 18px 12px 18px;
		}

		.faq-answer p {
			color: #7A7A7A;
			font-size: 12.5px;
			line-height: 1.6;
			margin: 0;
		}

		/* Responsive Design */
		@media (max-width: 991px) {
			.package-section {
				grid-template-columns: 1fr;
				gap: 25px;
			}

			.package-image {
				max-height: 350px;
			}
		}

		@media (max-width: 576px) {
			.package-main-section {
				padding: 15px 0 10px;
			}

			.package-header {
				margin-bottom: 15px;
			}

			.package-header h1 {
				font-size: 26px;
			}

			.package-subtitle {
				font-size: 14px;
			}

			.package-intro-text {
				font-size: 12px;
			}

			.package-content h2 {
				font-size: 20px;
			}

			.faq-title {
				font-size: 22px;
			}

			.faq-question h3 {
				font-size: 14px;
			}
		}
	</style>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else {
		do_action( 'wp_body_open' );
	}
	?>

	<div class="body_wrap">
		<div class="page_wrap">

			<?php
			// Include default header (same as yachts)
			get_template_part( 'skins/default/templates/header-default' );
			?>

			<!-- Breadcrumb -->
			<div class="package-breadcrumb">
				<div class="package-page-wrap">
					<nav class="breadcrumb-nav">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="breadcrumb-item"><?php esc_html_e( 'Home', 'yacht-rental' ); ?></a>
						<span class="breadcrumb-separator"></span>
						<a href="<?php echo esc_url( get_post_type_archive_link( 'cpt_packages' ) ); ?>" class="breadcrumb-item"><?php esc_html_e( 'Packages', 'yacht-rental' ); ?></a>
						<span class="breadcrumb-separator"></span>
						<span class="breadcrumb-item active"><?php the_title(); ?></span>
					</nav>
				</div>
			</div>

			<!-- Main Section -->
			<section class="package-main-section">
				<div class="package-page-wrap">
					<div class="package-header">
						<h1><?php the_title(); ?></h1>
						<?php if ( has_excerpt() ) : ?>
							<p class="package-subtitle"><?php echo esc_html( get_the_excerpt() ); ?></p>
						<?php endif; ?>
						<?php if ( get_the_content() ) : ?>
							<div class="package-intro-text">
								<?php the_content(); ?>
							</div>
						<?php endif; ?>
					</div>

					<!-- Package Section -->
					<div class="package-section">
						<div class="package-image">
							<?php
							if ( has_post_thumbnail() ) {
								the_post_thumbnail( 'full' );
							}
							?>
						</div>
						<div class="package-content">
							<?php if ( ! empty( $package_title ) ) : ?>
								<h2><?php echo esc_html( $package_title ); ?></h2>
							<?php endif; ?>

							<?php if ( ! empty( $features_array ) ) : ?>
								<ul class="features-list">
									<?php foreach ( $features_array as $feature ) : ?>
										<li><?php echo esc_html( $feature ); ?></li>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>

							<?php if ( ! empty( $contact_link ) ) : ?>
								<a href="<?php echo esc_url( $contact_link ); ?>" class="btn-red" target="_blank" rel="noopener">
									<?php esc_html_e( 'GET IN TOUCH', 'yacht-rental' ); ?>
								</a>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</section>

			<!-- FAQ Section -->
			<?php
			$faqs = array(
				array(
					'question' => __( 'How many people can the yacht accommodate?', 'yacht-rental' ),
					'answer'   => __( 'The yacht can comfortably accommodate up to 15 guests. This makes it perfect for family gatherings, birthday parties, and corporate events.', 'yacht-rental' ),
				),
				array(
					'question' => __( 'What is included in the package?', 'yacht-rental' ),
					'answer'   => __( 'Our package includes a 3+ hour luxury yacht cruise, beautiful decorations, personalized cake, red carpet welcome with drinks, water, ice, soft drinks, and optional add-ons like catering, DJ services, and professional photography.', 'yacht-rental' ),
				),
				array(
					'question' => __( 'Can we bring our own food and drinks?', 'yacht-rental' ),
					'answer'   => __( 'Yes, you\'re welcome to bring your own food and beverages. However, we also offer fine-dining catering from 5-star restaurants as an add-on service to make your celebration even more special.', 'yacht-rental' ),
				),
				array(
					'question' => __( 'What areas does the yacht cruise cover?', 'yacht-rental' ),
					'answer'   => __( 'Our yacht cruise takes you past Dubai\'s iconic landmarks including the Dubai Marina, Ain Dubai, Palm Jumeirah, Atlantis Hotel, and the stunning Burj Al Arab, offering breathtaking views of Dubai\'s skyline.', 'yacht-rental' ),
				),
				array(
					'question' => __( 'How far in advance should we book?', 'yacht-rental' ),
					'answer'   => __( 'We recommend booking at least 1-2 weeks in advance to ensure availability, especially during peak seasons and weekends. However, we\'ll do our best to accommodate last-minute bookings based on availability.', 'yacht-rental' ),
				),
			);
			?>
			<section class="package-faq-section">
				<div class="package-page-wrap">
					<h2 class="faq-title"><?php esc_html_e( 'Frequently Asked Questions', 'yacht-rental' ); ?></h2>
					<div class="faq-container">
						<?php foreach ( $faqs as $faq ) : ?>
							<div class="faq-item">
								<div class="faq-question">
									<h3><?php echo esc_html( $faq['question'] ); ?></h3>
									<span class="faq-toggle">+</span>
								</div>
								<div class="faq-answer">
									<p><?php echo esc_html( $faq['answer'] ); ?></p>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</section>

			<?php
			// Include custom footer (same as yachts)
			get_template_part( 'skins/default/templates/footer-custom' );
			?>

		</div><!-- .page_wrap -->
	</div><!-- .body_wrap -->

	<script>
		// FAQ Accordion functionality
		document.addEventListener('DOMContentLoaded', function() {
			document.querySelectorAll('.faq-question').forEach(function(question) {
				question.addEventListener('click', function() {
					const faqItem = this.parentElement;
					const isActive = faqItem.classList.contains('active');

					// Close all FAQ items
					document.querySelectorAll('.faq-item').forEach(function(item) {
						item.classList.remove('active');
					});

					// Open clicked item if it wasn't active
					if (!isActive) {
						faqItem.classList.add('active');
					}
				});
			});
		});
	</script>

	<?php wp_footer(); ?>

</body>
</html>
