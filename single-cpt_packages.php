<?php
/**
 * Single Package Template
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
$head_description = get_post_meta( get_the_ID(), '_package_head_description', true );
$bottom_description = get_post_meta( get_the_ID(), '_package_bottom_description', true );

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
// Force default header (not Elementor/custom)
get_template_part( 'skins/default/templates/header-default' );

// Mobile menu
if ( apply_filters( 'yacht_rental_filter_use_navi_mobile', true ) ) {
	get_template_part( 'skins/default/templates/header-navi-mobile' );
}
?>

<style>
		/* Package-specific styles */
		.package-container {
			max-width: 1200px;
			margin: 0 auto;
			margin-top: 0;
			padding: 139px 20px;
		}

		/* Breadcrumb Styles */
		.package-breadcrumb {
			text-align: center;
			margin-bottom: 30px;
			padding: 0;
			font-size: 16px;
			color: #666;
		}

		.package-breadcrumb a {
			color: #999;
			text-decoration: none;
			transition: color 0.3s ease;
			font-weight: 500;
		}

		.package-breadcrumb a:hover {
			color: #1a2332;
		}

		.package-breadcrumb .separator {
			margin: 0 12px;
			color: #d4a853;
			font-size: 12px;
		}

		.package-breadcrumb .current {
			color: #1a2332;
			font-weight: 600;
		}

		/* Main Section */
		.package-main-section {
			background-color: #fff;
			padding: 12px;
		}

		.package-header {
			text-align: center;
			margin-bottom: 15px;
		}

		.package-rating {
			color: #ffa500;
			font-size: 20px;
			line-height: 1;
			margin: 0 0 10px 0;
			padding: 0;
		}

		.package-header h1 {
			font-size: 34px;
			font-weight: 700;
			color: #050C29;
			margin-bottom: 12px;
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

		/* Package Section */
		.package-section {
			display: grid;
			grid-template-columns: 50% 50%;
			gap: 50px;
			align-items: start;
			margin-top: 30px;
		}

		.package-image-wrapper {
			display: flex;
			flex-direction: column;
			gap: 20px;
		}

		.package-image {
			position: relative;
			border-radius: 12px;
			overflow: hidden;
			box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
			transition: all 0.4s ease;
			height: 500px;
		}

		/* Head Description - after hero header */
		.package-head-description {
			max-width: 900px;
			margin: 0 auto 30px;
			text-align: center;
		}

		.package-head-description p {
			margin: 0 0 15px;
			color: #54595F;
			font-size: 16px;
			line-height: 1.8;
		}

		.package-head-description p:last-child {
			margin-bottom: 0;
		}

		/* Bottom Description - after package section */
		.package-bottom-description {
			margin-top: 50px;
			padding: 0;
		}

		.package-bottom-description p {
			margin: 0 0 18px;
			color: #54595F;
			font-size: 16px;
			line-height: 1.8;
		}

		.package-bottom-description p:last-child {
			margin-bottom: 0;
		}

		.package-bottom-description h2,
		.package-bottom-description h3,
		.package-bottom-description h4 {
			color: #050C29;
			margin: 25px 0 15px;
		}

		.package-bottom-description ul,
		.package-bottom-description ol {
			margin: 0 0 18px 20px;
			color: #54595F;
			line-height: 1.8;
		}

		.package-bottom-description a {
			color: #61CE70;
			text-decoration: underline;
		}

		.package-bottom-description a:hover {
			color: #4FB85E;
		}

		.package-image:hover {
			box-shadow: 0 15px 50px rgba(0, 0, 0, 0.25);
			transform: translateY(-5px);
		}

		.package-image::before {
			content: '';
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: linear-gradient(135deg, rgba(97, 206, 112, 0.1) 0%, rgba(188, 24, 51, 0.1) 100%);
			opacity: 0;
			transition: opacity 0.4s ease;
			z-index: 1;
		}

		.package-image:hover::before {
			opacity: 1;
		}

		.package-image img {
			width: 100%;
			height: 100%;
			display: block;
			object-fit: cover;
			object-position: center;
			transition: transform 0.4s ease;
		}

		.package-image:hover img {
			transform: scale(1.05);
		}

		.package-content {
			display: flex;
			flex-direction: column;
			justify-content: flex-start;
			padding: 30px 30px 20px 30px;
			background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
			border-radius: 0;
			box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
		}

		.package-content h2 {
			font-size: 28px;
			font-weight: 700;
			color: #050C29;
			margin-bottom: 20px;
			line-height: 1.3;
			letter-spacing: -0.3px;
			position: relative;
			padding-bottom: 15px;
		}

		.package-content h2::after {
			content: '';
			position: absolute;
			bottom: 0;
			left: 0;
			width: 60px;
			height: 3px;
			background: linear-gradient(90deg, #61CE70 0%, #4FB85E 100%);
			border-radius: 2px;
		}

		.features-list {
			list-style: none;
			margin-bottom: 12px;
			padding: 0;
		}

		.features-list li {
			padding: 4px 0;
			color: #54595F;
			font-size: 14px;
			display: flex;
			align-items: flex-start;
			gap: 12px;
			transition: all 0.3s ease;
			border-left: 2px solid transparent;
			padding-left: 0;
		}

		.features-list li:hover {
			color: #050C29;
		}

		.features-list li::before {
			content: "✓";
			color: #61CE70;
			font-weight: 700;
			font-size: 18px;
			flex-shrink: 0;
			margin-top: 2px;
			width: 24px;
			height: 24px;
			display: flex;
			align-items: center;
			justify-content: center;
			background: rgba(97, 206, 112, 0.1);
			border-radius: 50%;
		}

		/* Buttons */
		.btn-red {
			background: linear-gradient(135deg, #BC1833 0%, #D41F3D 100%);
			color: #fff;
			display: inline-flex;
			align-items: center;
			justify-content: center;
			gap: 8px;
			padding: 10px 28px;
			font-size: 12px;
			font-weight: 500;
			text-decoration: none;
			border-radius: 0;
			transition: all 0.3s ease;
			border: none;
			cursor: pointer;
			text-align: center;
			letter-spacing: 0.5px;
			text-transform: uppercase;
			box-shadow: 0 2px 8px rgba(188, 24, 51, 0.25);
			margin-bottom: 0;
			margin-top: 0;
		}

		.btn-red:hover {
			background: linear-gradient(135deg, #D41F3D 0%, #BC1833 100%);
			box-shadow: 0 4px 12px rgba(188, 24, 51, 0.35);
		}

		.btn-red::after {
			content: "✈";
			font-size: 14px;
			transform: rotate(45deg);
			display: inline-block;
		}

		/* FAQ Section */
		.package-faq-section {
			margin: 60px 0 40px 0;
			padding: 0;
		}

		.faq-title {
			text-align: center;
			font-size: 32px;
			color: #1a2332;
			margin: 0 0 40px 0;
			padding: 0;
			font-weight: 700;
		}

		.faq-container {
			max-width: 900px;
			margin: 0 auto;
			padding: 0;
		}

		.faq-item {
			background: #fff;
			margin: 0 0 15px 0;
			padding: 0;
			border-radius: 12px;
			overflow: hidden;
			box-shadow: 0 4px 20px rgba(0,0,0,0.08);
			transition: all 0.3s ease;
		}

		.faq-item:hover {
			box-shadow: 0 8px 30px rgba(0,0,0,0.12);
		}

		.faq-question {
			padding: 20px 25px;
			cursor: pointer;
			display: flex;
			justify-content: space-between;
			align-items: center;
			font-size: 17px;
			font-weight: 600;
			color: #1a2332;
			background: #fff;
			transition: all 0.3s ease;
			margin: 0;
		}

		.faq-question span:first-child {
			flex: 1;
		}

		.faq-question:hover {
			background: #f8f9fa;
			color: #25d366;
		}

		.faq-question.active {
			background: #f0f9f4;
			color: #25d366;
		}

		.faq-toggle {
			font-size: 20px;
			font-weight: bold;
			transition: transform 0.3s ease;
			color: #25d366;
			margin: 0;
			padding: 0;
		}

		.faq-question.active .faq-toggle {
			transform: rotate(45deg);
		}

		.faq-answer {
			max-height: 0;
			overflow: hidden;
			transition: max-height 0.3s ease, padding 0.3s ease;
			padding: 0 25px;
			color: #666;
			line-height: 1.7;
			font-size: 15px;
			margin: 0;
		}

		.faq-answer.active {
			max-height: 500px;
			padding: 15px 25px 20px 25px;
		}

		.faq-answer p {
			margin: 0;
			padding: 0;
		}

		/* Responsive Design */
		@media (max-width: 991px) {
			.package-section {
				grid-template-columns: 1fr;
				gap: 25px;
			}

			.package-image-wrapper {
				gap: 15px;
			}

			.package-image {
				height: 400px;
			}

			.package-head-description {
				margin-bottom: 25px;
			}

			.package-bottom-description {
				margin-top: 40px;
			}
		}

		@media (max-width: 576px) {
			.package-container {
				padding: 80px 20px 20px;
			}

			.package-main-section {
				padding: 15px 0 10px;
			}

			.package-header {
				margin-bottom: 15px;
			}

			.package-header h1 {
				font-size: 26px;
			}

			.package-rating {
				font-size: 18px;
			}

			.package-subtitle {
				font-size: 14px;
			}

			.package-image {
				height: 300px;
			}

			.package-head-description {
				margin-bottom: 20px;
			}

			.package-head-description p {
				font-size: 14px;
			}

			.package-bottom-description {
				margin-top: 30px;
			}

			.package-bottom-description p {
				font-size: 14px;
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

<div class="package-container">

				<!-- Breadcrumb -->
				<div class="package-breadcrumb">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'yacht-rental' ); ?></a>
					<span class="separator">◆</span>
					<a href="<?php echo esc_url( get_post_type_archive_link( 'cpt_packages' ) ); ?>"><?php esc_html_e( 'Packages', 'yacht-rental' ); ?></a>
					<span class="separator">◆</span>
					<span class="current"><?php the_title(); ?></span>
				</div>

				<!-- Main Section -->
				<section class="package-main-section">
					<div class="package-header">
						<div class="package-rating">★★★★★</div>
						<h1><?php the_title(); ?></h1>
						<?php if ( has_excerpt() ) : ?>
							<p class="package-subtitle"><?php echo esc_html( get_the_excerpt() ); ?></p>
						<?php endif; ?>
					</div>

					<?php if ( ! empty( $head_description ) ) : ?>
						<div class="package-head-description">
							<?php echo wp_kses_post( $head_description ); ?>
						</div>
					<?php endif; ?>

					<!-- Package Section -->
					<div class="package-section">
						<div class="package-image-wrapper">
							<div class="package-image">
								<?php
								if ( has_post_thumbnail() ) {
									the_post_thumbnail( 'full' );
								}
								?>
							</div>
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

					<?php if ( ! empty( $bottom_description ) ) : ?>
						<div class="package-bottom-description">
							<?php echo wp_kses_post( $bottom_description ); ?>
						</div>
					<?php endif; ?>
				</section>

				<!-- FAQ Section -->
				<?php
				// Get FAQ from custom field, or use defaults
				$faqs = get_post_meta( get_the_ID(), '_package_faq', true );
				if ( ! is_array( $faqs ) || empty( $faqs ) ) {
					// Default FAQs if none are set
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
							'answer'   => __( 'Our yacht cruise takes you past Baku\'s iconic landmarks including the Baku Boulevard, Flame Towers, Crystal Hall, and the beautiful Caspian Sea coastline, offering breathtaking views of Baku\'s skyline.', 'yacht-rental' ),
						),
						array(
							'question' => __( 'How far in advance should we book?', 'yacht-rental' ),
							'answer'   => __( 'We recommend booking at least 1-2 weeks in advance to ensure availability, especially during peak seasons and weekends. However, we\'ll do our best to accommodate last-minute bookings based on availability.', 'yacht-rental' ),
						),
					);
				}

				// Show FAQ section
				if ( ! empty( $faqs ) ) :
				?>
				<section class="package-faq-section">
					<h2 class="faq-title"><?php esc_html_e( 'Frequently Asked Questions', 'yacht-rental' ); ?></h2>
					<div class="faq-container">
						<?php foreach ( $faqs as $faq ) : ?>
							<?php if ( ! empty( $faq['question'] ) && ! empty( $faq['answer'] ) ) : ?>
							<div class="faq-item">
								<div class="faq-question">
									<span><?php echo esc_html( $faq['question'] ); ?></span>
									<span class="faq-toggle">+</span>
								</div>
								<div class="faq-answer">
									<p><?php echo esc_html( $faq['answer'] ); ?></p>
								</div>
							</div>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				</section>
				<?php endif; ?>

		</div><!-- .package-container -->

<?php
	// Generate schema markup for SEO
	$schema_markup = array();

	// 1. BreadcrumbList Schema
	$breadcrumb_schema = array(
		'@context' => 'https://schema.org',
		'@type' => 'BreadcrumbList',
		'itemListElement' => array(
			array(
				'@type' => 'ListItem',
				'position' => 1,
				'name' => __( 'Home', 'yacht-rental' ),
				'item' => home_url( '/' ),
			),
			array(
				'@type' => 'ListItem',
				'position' => 2,
				'name' => __( 'Packages', 'yacht-rental' ),
				'item' => get_post_type_archive_link( 'cpt_packages' ),
			),
			array(
				'@type' => 'ListItem',
				'position' => 3,
				'name' => get_the_title(),
				'item' => get_permalink(),
			),
		),
	);
	$schema_markup[] = $breadcrumb_schema;

	// 2. FAQPage Schema
	$faq_schema_items = array();
	foreach ( $faqs as $faq ) {
		$faq_schema_items[] = array(
			'@type' => 'Question',
			'name' => $faq['question'],
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text' => $faq['answer'],
			),
		);
	}

	$faq_schema = array(
		'@context' => 'https://schema.org',
		'@type' => 'FAQPage',
		'mainEntity' => $faq_schema_items,
	);
	$schema_markup[] = $faq_schema;

	// 3. Service Schema for the Package
	$service_schema = array(
		'@context' => 'https://schema.org',
		'@type' => 'Service',
		'name' => get_the_title(),
		'description' => get_the_excerpt() ? get_the_excerpt() : wp_trim_words( get_the_content(), 30 ),
		'provider' => array(
			'@type' => 'Organization',
			'name' => 'Bakuyachts.com',
			'url' => home_url( '/' ),
		),
		'areaServed' => array(
			'@type' => 'City',
			'name' => 'Baku',
		),
		'serviceType' => 'Yacht Rental Package',
	);

	if ( has_post_thumbnail() ) {
		$service_schema['image'] = get_the_post_thumbnail_url( get_the_ID(), 'full' );
	}

	if ( ! empty( $package_features ) ) {
		$service_schema['offers'] = array(
			'@type' => 'Offer',
			'description' => wp_trim_words( $package_features, 50 ),
		);
	}

	$schema_markup[] = $service_schema;

	// Output all schema markup
	foreach ( $schema_markup as $schema ) {
		echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n\t";
	}
	?>

	<script>
		// FAQ Accordion functionality
		document.addEventListener('DOMContentLoaded', function() {
			var faqQuestions = document.querySelectorAll('.faq-question');
			faqQuestions.forEach(function(question) {
				question.addEventListener('click', function() {
					var faqItem = this.parentElement;
					var answer = this.nextElementSibling;

					// Close other open items
					document.querySelectorAll('.faq-item').forEach(function(item) {
						if (item !== faqItem) {
							item.querySelector('.faq-question').classList.remove('active');
							item.querySelector('.faq-answer').classList.remove('active');
						}
					});

					// Toggle current item
					this.classList.toggle('active');
					answer.classList.toggle('active');
				});
			});
		});
	</script>

	</div><!-- .package-container -->

</div><!-- .page_wrap -->
</div><!-- .body_wrap -->

<?php get_footer('custom'); ?>
