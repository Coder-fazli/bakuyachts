<?php
/**
 * Single Yacht Template
 * Based on yacht-single-template.html
 */

// Get post data
if ( have_posts() ) {
    the_post();
}

// Get meta data
$gallery_ids = get_post_meta(get_the_ID(), '_yr_yacht_gallery_ids', true);
if (!is_array($gallery_ids)) {
    $gallery_ids = array();
}

$old_price = get_post_meta(get_the_ID(), '_yr_yacht_old_price', true);
$new_price = get_post_meta(get_the_ID(), '_yr_yacht_new_price', true);
$price_label = get_post_meta(get_the_ID(), '_yr_yacht_price_label', true);

$whatsapp = get_post_meta(get_the_ID(), '_yr_yacht_whatsapp', true);
$phone = get_post_meta(get_the_ID(), '_yr_yacht_phone', true);

$features = get_post_meta(get_the_ID(), '_yr_yacht_features', true);
$offers = get_post_meta(get_the_ID(), '_yr_yacht_offers', true);
$faq = get_post_meta(get_the_ID(), '_yr_yacht_faq', true);

get_header('custom');
?>

<style>
    /* === YACHT SINGLE CONTAINER === */
    .yrsp-yacht-container {
        max-width: 1200px !important;
        margin: 0 auto !important;
        padding: 200px 20px 40px 20px !important;
        background: #fff !important;
        box-sizing: border-box !important;
        position: relative !important;
        z-index: 1 !important;
    }

    .yrsp-yacht-container * {
        box-sizing: border-box !important;
    }

    /* === BREADCRUMBS === */
    .yrsp-breadcrumbs {
        text-align: center !important;
        margin-bottom: 30px !important;
        padding: 0 !important;
        font-size: 16px !important;
        color: #666 !important;
    }

    .yrsp-breadcrumbs a {
        color: #999 !important;
        text-decoration: none !important;
        transition: color 0.3s ease !important;
        font-weight: 500 !important;
    }

    .yrsp-breadcrumbs a:hover {
        color: #1a2332 !important;
    }

    .yrsp-breadcrumbs .separator {
        margin: 0 12px !important;
        color: #d4a853 !important;
        font-size: 12px !important;
    }

    .yrsp-breadcrumbs .current {
        color: #1a2332 !important;
        font-weight: 600 !important;
    }

    /* === TITLE SECTION === */
    .yrsp-title {
        text-align: center !important;
        margin-bottom: 30px !important;
    }

    .yrsp-title h1 {
        font-size: 48px !important;
        color: #1a2332 !important;
        margin: 0 0 10px 0 !important;
        padding: 0 !important;
        font-weight: 700 !important;
        line-height: 1.2 !important;
    }

    .yrsp-rating {
        color: #ffa500 !important;
        font-size: 20px !important;
        line-height: 1 !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    /* === GALLERY SLIDER === */
    .yrsp-gallery-wrapper {
        margin: 0 0 40px 0 !important;
        padding: 0 !important;
    }

    .yrsp-gallery-row {
        position: relative !important;
        overflow: hidden !important;
        border-radius: 15px !important;
        box-shadow: 0 15px 60px rgba(0,0,0,0.25) !important;
        background: transparent !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .yrsp-gallery-swiper {
        width: 100% !important;
        height: 400px !important;
        background: transparent !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .yrsp-gallery-swiper .swiper-wrapper {
        margin: 0 !important;
        padding: 0 !important;
    }

    .yrsp-gallery-swiper .swiper-slide {
        display: grid !important;
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 2px !important;
        padding: 0 !important;
        background: transparent !important;
        margin: 0 !important;
    }

    .yrsp-gallery-item {
        position: relative !important;
        overflow: hidden !important;
        border-radius: 0 !important;
        height: 400px !important;
        background: transparent !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .yrsp-gallery-item img {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
        transition: transform 0.3s ease !important;
        display: block !important;
        margin: 0 !important;
        padding: 0 !important;
        border: none !important;
    }

    .yrsp-gallery-item:hover img {
        transform: scale(1.1) !important;
    }

    /* Swiper Navigation */
    .yrsp-gallery-swiper .swiper-button-next,
    .yrsp-gallery-swiper .swiper-button-prev {
        color: #fff !important;
        background: rgba(26, 35, 50, 0.8) !important;
        width: 45px !important;
        height: 45px !important;
        border-radius: 50% !important;
        transition: all 0.3s ease !important;
    }

    .yrsp-gallery-swiper .swiper-button-next:hover,
    .yrsp-gallery-swiper .swiper-button-prev:hover {
        background: rgba(26, 35, 50, 1) !important;
        transform: scale(1.1) !important;
    }

    .yrsp-gallery-swiper .swiper-button-next:after,
    .yrsp-gallery-swiper .swiper-button-prev:after {
        font-size: 20px !important;
        font-weight: bold !important;
    }

    .yrsp-gallery-swiper .swiper-pagination-bullet {
        background: #1a2332 !important;
        width: 12px !important;
        height: 12px !important;
        opacity: 0.5 !important;
    }

    .yrsp-gallery-swiper .swiper-pagination-bullet-active {
        background: #25d366 !important;
        opacity: 1 !important;
    }

    /* === PRICE SECTION === */
    .yrsp-price-section {
        display: flex !important;
        gap: 20px !important;
        justify-content: center !important;
        margin: 0 0 30px 0 !important;
        padding: 0 !important;
        flex-wrap: wrap !important;
    }

    .yrsp-price-box {
        flex: 1 !important;
        max-width: 500px !important;
        text-align: center !important;
        padding: 25px 30px !important;
        border: none !important;
        border-radius: 12px !important;
        background: #fff !important;
        box-shadow: 0 8px 30px rgba(0,0,0,0.1) !important;
        transition: transform 0.3s ease !important;
        margin: 0 !important;
    }

    .yrsp-price-box:hover {
        transform: translateY(-5px) !important;
        box-shadow: 0 12px 40px rgba(0,0,0,0.15) !important;
    }

    .yrsp-old-price {
        color: #ff0000 !important;
        font-size: 32px !important;
        font-weight: bold !important;
        text-decoration: line-through !important;
        margin: 0 10px 0 0 !important;
        padding: 0 !important;
        display: inline-block !important;
    }

    .yrsp-new-price {
        color: #ff0000 !important;
        font-size: 32px !important;
        font-weight: bold !important;
        display: inline-block !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .yrsp-price-label {
        color: #1a2332 !important;
        font-size: 22px !important;
        font-weight: 600 !important;
        display: block !important;
        margin: 5px 0 0 0 !important;
        padding: 0 !important;
    }

    /* === DESCRIPTION === */
    .yrsp-description {
        text-align: center !important;
        font-size: 16px !important;
        line-height: 1.8 !important;
        color: #555 !important;
        margin: 0 0 30px 0 !important;
        padding: 30px !important;
        background: #fff !important;
        border-radius: 12px !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08) !important;
    }

    .yrsp-description p {
        margin: 0 !important;
        padding: 0 !important;
    }

    /* === CTA BUTTONS === */
    .yrsp-cta-buttons {
        display: flex !important;
        gap: 20px !important;
        justify-content: center !important;
        margin: 0 0 50px 0 !important;
        padding: 0 !important;
        flex-wrap: wrap !important;
    }

    .yrsp-btn {
        padding: 18px 60px !important;
        font-size: 16px !important;
        font-weight: 700 !important;
        border: none !important;
        border-radius: 8px !important;
        cursor: pointer !important;
        transition: all 0.3s ease !important;
        text-decoration: none !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 10px !important;
        box-shadow: 0 6px 20px rgba(0,0,0,0.15) !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
        margin: 0 !important;
    }

    .yrsp-cta-buttons .yrsp-btn-whatsapp,
    a.yrsp-btn-whatsapp {
        background: #25d366 !important;
        color: #ffffff !important;
        font-size: 16px !important;
        font-weight: 600 !important;
        padding: 16px 40px !important;
        border-radius: 0 !important;
        box-shadow: none !important;
        border: none !important;
        text-transform: uppercase !important;
        letter-spacing: 1px !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 10px !important;
        transition: all 0.3s ease !important;
    }

    .yrsp-cta-buttons .yrsp-btn-whatsapp:hover,
    a.yrsp-btn-whatsapp:hover {
        background: #128c7e !important;
        transform: none !important;
        box-shadow: none !important;
        color: #ffffff !important;
        text-decoration: none !important;
    }

    .yrsp-btn-call {
        background: #1a2332 !important;
        color: #fff !important;
    }

    .yrsp-btn-call:hover {
        background: #2d3e50 !important;
        transform: translateY(-3px) !important;
        box-shadow: 0 10px 30px rgba(26, 35, 50, 0.4) !important;
        color: #fff !important;
        text-decoration: none !important;
    }

    /* === FEATURES SECTION === */
    .yrsp-features-section {
        display: grid !important;
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 30px !important;
        margin: 50px 0 !important;
        padding: 0 !important;
    }

    .yrsp-features-column {
        background: #fff !important;
        padding: 30px !important;
        border-radius: 8px !important;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08) !important;
        transition: all 0.3s ease !important;
        border: 1px solid #eee !important;
        margin: 0 !important;
    }

    .yrsp-features-column:hover {
        box-shadow: 0 4px 15px rgba(0,0,0,0.12) !important;
        border-color: #ddd !important;
    }

    .yrsp-features-column h2 {
        font-size: 26px !important;
        color: #1a2332 !important;
        margin: 0 0 25px 0 !important;
        padding: 0 0 15px 0 !important;
        font-weight: 700 !important;
        position: relative !important;
    }

    .yrsp-features-column h2:after {
        content: '' !important;
        position: absolute !important;
        left: 0 !important;
        bottom: 0 !important;
        width: 60px !important;
        height: 4px !important;
        background: linear-gradient(90deg, #25d366, #1fb855) !important;
        border-radius: 2px !important;
    }

    .yrsp-feature-list {
        list-style: none !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .yrsp-feature-list li {
        padding: 6px 0 6px 35px !important;
        position: relative !important;
        font-size: 15px !important;
        line-height: 1.6 !important;
        color: #555 !important;
        transition: all 0.2s ease !important;
        margin: 0 !important;
    }

    .yrsp-feature-list li:hover {
        color: #1a2332 !important;
        transform: translateX(5px) !important;
    }

    .yrsp-feature-list li:before {
        content: "✓" !important;
        position: absolute !important;
        left: 0 !important;
        top: 6px !important;
        width: 22px !important;
        height: 22px !important;
        background: #25d366 !important;
        color: #fff !important;
        border-radius: 50% !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-weight: bold !important;
        font-size: 12px !important;
        box-shadow: none !important;
    }

    /* === FAQ SECTION === */
    .yrsp-faq-section {
        margin: 60px 0 40px 0 !important;
        padding: 0 !important;
    }

    .yrsp-faq-title {
        text-align: center !important;
        font-size: 32px !important;
        color: #1a2332 !important;
        margin: 0 0 40px 0 !important;
        padding: 0 !important;
        font-weight: 700 !important;
    }

    .yrsp-faq-container {
        max-width: 900px !important;
        margin: 0 auto !important;
        padding: 0 !important;
    }

    .yrsp-faq-item {
        background: #fff !important;
        margin: 0 0 15px 0 !important;
        padding: 0 !important;
        border-radius: 12px !important;
        overflow: hidden !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08) !important;
        transition: all 0.3s ease !important;
    }

    .yrsp-faq-item:hover {
        box-shadow: 0 8px 30px rgba(0,0,0,0.12) !important;
    }

    .yrsp-faq-question {
        padding: 20px 25px !important;
        cursor: pointer !important;
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        font-size: 17px !important;
        font-weight: 600 !important;
        color: #1a2332 !important;
        background: #fff !important;
        transition: all 0.3s ease !important;
        margin: 0 !important;
    }

    .yrsp-faq-question:hover {
        background: #f8f9fa !important;
        color: #25d366 !important;
    }

    .yrsp-faq-question.active {
        background: #f0f9f4 !important;
        color: #25d366 !important;
    }

    .yrsp-faq-icon {
        font-size: 20px !important;
        font-weight: bold !important;
        transition: transform 0.3s ease !important;
        color: #25d366 !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .yrsp-faq-question.active .yr-faq-icon {
        transform: rotate(45deg) !important;
    }

    .yrsp-faq-answer {
        max-height: 0 !important;
        overflow: hidden !important;
        transition: max-height 0.3s ease, padding 0.3s ease !important;
        padding: 0 25px !important;
        color: #666 !important;
        line-height: 1.7 !important;
        font-size: 15px !important;
        margin: 0 !important;
    }

    .yrsp-faq-answer.active {
        max-height: 500px !important;
        padding: 15px 25px 20px 25px !important;
    }

    .yrsp-faq-answer p {
        margin: 0 !important;
        padding: 0 !important;
    }

    /* === RESPONSIVE === */
    @media (max-width: 768px) {
        .yrsp-yacht-title h1 {
            font-size: 28px !important;
        }

        .yrsp-gallery-swiper {
            height: auto !important;
        }

        .yrsp-gallery-swiper .swiper-slide {
            grid-template-columns: 1fr !important;
        }

        .yrsp-gallery-item {
            height: 250px !important;
        }

        .yrsp-features-section {
            grid-template-columns: 1fr !important;
        }

        .yrsp-price-section {
            flex-direction: column !important;
        }

        .yrsp-cta-buttons {
            flex-direction: column !important;
        }

        .yrsp-btn {
            width: 100% !important;
            justify-content: center !important;
        }

        .yrsp-faq-title {
            font-size: 26px !important;
        }

        .yrsp-faq-question {
            font-size: 15px !important;
            padding: 15px 20px !important;
        }
    }
    </style>

<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

<div class="yrsp-yacht-container">

    <!-- Breadcrumbs -->
    <div class="yrsp-breadcrumbs">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
        <span class="separator">◆</span>
        <a href="<?php echo esc_url( get_post_type_archive_link( 'cpt_yachts' ) ); ?>">Yacht Rental</a>
        <span class="separator">◆</span>
        <span class="current"><?php the_title(); ?></span>
    </div>

    <!-- Title -->
    <div class="yrsp-title">
        <h1><?php the_title(); ?></h1>
        <div class="yrsp-rating">★★★★★</div>
    </div>

    <!-- Gallery Slider -->
    <?php if (!empty($gallery_ids) && count($gallery_ids) > 0): ?>
    <div class="yrsp-gallery-wrapper">
        <div class="yrsp-gallery-row">
            <div class="swiper yrsp-gallery-swiper">
                <div class="swiper-wrapper">
                    <?php
                    // Group images by 2 (2 images per slide)
                    $chunks = array_chunk($gallery_ids, 2);
                    foreach ($chunks as $chunk):
                    ?>
                        <div class="swiper-slide">
                            <?php foreach ($chunk as $image_id): ?>
                                <div class="yrsp-gallery-item">
                                    <?php echo wp_get_attachment_image($image_id, 'full'); ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Price Section - HIDDEN -->
    <?php /* if ($old_price || $new_price): ?>
    <div class="yrsp-price-section">
        <?php if ($old_price): ?>
            <div class="yrsp-price-box">
                <span class="yrsp-old-price"><?php echo esc_html($old_price); ?></span>
                <?php if ($price_label): ?>
                    <span class="yrsp-price-label"><?php echo esc_html($price_label); ?></span>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($new_price): ?>
            <div class="yrsp-price-box">
                <span class="yrsp-new-price">NOW - <?php echo esc_html($new_price); ?></span>
                <?php if ($price_label): ?>
                    <span class="yrsp-price-label"><?php echo esc_html($price_label); ?></span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php endif; */ ?>

    <!-- Description -->
    <?php if (get_the_content()): ?>
    <div class="yrsp-description">
        <?php the_content(); ?>
    </div>
    <?php endif; ?>

    <!-- CTA Buttons -->
    <?php if ($whatsapp): ?>
    <div class="yrsp-cta-buttons">
        <?php if ($whatsapp): ?>
            <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $whatsapp)); ?>"
               class="yrsp-btn yrsp-btn-whatsapp" target="_blank">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                WHATSAPP US
            </a>
        <?php endif; ?>

        <?php /* if ($phone): ?>
            <a href="tel:<?php echo esc_attr($phone); ?>" class="yrsp-btn yr-btn-call">
                <span>📞</span> CALL US
            </a>
        <?php endif; */ ?>
    </div>
    <?php endif; ?>

    <!-- Features Section -->
    <?php if ((!empty($features) && is_array($features)) || (!empty($offers) && is_array($offers))): ?>
    <div class="yrsp-features-section">

        <!-- Left Column: Key Features -->
        <?php if (!empty($features) && is_array($features)): ?>
        <div class="yrsp-features-column">
            <h2>Key Features of <?php the_title(); ?></h2>
            <ul class="yrsp-feature-list">
                <?php foreach ($features as $feature): ?>
                    <?php if (!empty($feature)): ?>
                        <li><?php echo esc_html($feature); ?></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <!-- Right Column: We Also Offer -->
        <?php if (!empty($offers) && is_array($offers)): ?>
        <div class="yrsp-features-column">
            <h2>We also Offer:</h2>
            <ul class="yrsp-feature-list">
                <?php foreach ($offers as $offer): ?>
                    <?php if (!empty($offer)): ?>
                        <li><?php echo esc_html($offer); ?></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

    </div>
    <?php endif; ?>

    <!-- FAQ Section -->
    <?php if (!empty($faq) && is_array($faq)): ?>
    <div class="yrsp-faq-section">
        <h2 class="yrsp-faq-title">Frequently Asked Questions</h2>
        <div class="yrsp-faq-container">

            <?php foreach ($faq as $index => $item): ?>
                <?php if (!empty($item['question']) && !empty($item['answer'])): ?>
                    <div class="yrsp-faq-item">
                        <div class="yrsp-faq-question">
                            <span><?php echo esc_html($item['question']); ?></span>
                            <span class="yrsp-faq-icon">+</span>
                        </div>
                        <div class="yrsp-faq-answer">
                            <p><?php echo esc_html($item['answer']); ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>

        </div>
    </div>
    <?php endif; ?>

</div>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize gallery slider
    <?php if (!empty($gallery_ids) && count($gallery_ids) > 0): ?>
    var yrspGallerySwiper = new Swiper('.yrsp-gallery-swiper', {
        slidesPerView: 1,
        spaceBetween: 0,
        navigation: {
            nextEl: '.yrsp-gallery-swiper .swiper-button-next',
            prevEl: '.yrsp-gallery-swiper .swiper-button-prev',
        },
        pagination: {
            el: '.yrsp-gallery-swiper .swiper-pagination',
            clickable: true,
        },
        loop: true,
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
    });
    <?php endif; ?>

    // FAQ Accordion functionality
    var faqQuestions = document.querySelectorAll('.yrsp-faq-question');
    faqQuestions.forEach(function(question) {
        question.addEventListener('click', function() {
            var faqItem = this.parentElement;
            var answer = this.nextElementSibling;

            // Close other open items
            document.querySelectorAll('.yrsp-faq-item').forEach(function(item) {
                if (item !== faqItem) {
                    item.querySelector('.yrsp-faq-question').classList.remove('active');
                    item.querySelector('.yrsp-faq-answer').classList.remove('active');
                }
            });

            // Toggle current item
            this.classList.toggle('active');
            answer.classList.toggle('active');
        });
    });
});
</script>

</div><!-- .yrsp-yacht-container -->

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
                'name' => __( 'Yachts', 'yacht-rental' ),
                'item' => get_post_type_archive_link( 'cpt_yachts' ),
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

    // 2. FAQPage Schema (if FAQ exists)
    if ( ! empty( $faq ) && is_array( $faq ) ) {
        $faq_schema_items = array();
        foreach ( $faq as $item ) {
            if ( ! empty( $item['question'] ) && ! empty( $item['answer'] ) ) {
                $faq_schema_items[] = array(
                    '@type' => 'Question',
                    'name' => $item['question'],
                    'acceptedAnswer' => array(
                        '@type' => 'Answer',
                        'text' => $item['answer'],
                    ),
                );
            }
        }

        if ( ! empty( $faq_schema_items ) ) {
            $faq_schema = array(
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'mainEntity' => $faq_schema_items,
            );
            $schema_markup[] = $faq_schema;
        }
    }

    // 3. Product/Service Schema for the Yacht
    $yacht_schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Product',
        'name' => get_the_title(),
        'description' => get_the_excerpt() ? get_the_excerpt() : wp_trim_words( get_the_content(), 30 ),
        'brand' => array(
            '@type' => 'Organization',
            'name' => 'Bakuyachts.com',
        ),
    );

    if ( has_post_thumbnail() ) {
        $yacht_schema['image'] = get_the_post_thumbnail_url( get_the_ID(), 'full' );
    }

    $schema_markup[] = $yacht_schema;

    // Output all schema markup
    foreach ( $schema_markup as $schema ) {
        echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n    ";
    }
    ?>

<?php get_footer('custom'); ?>
