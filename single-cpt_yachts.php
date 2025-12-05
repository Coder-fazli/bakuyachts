<?php
/**
 * Single Yacht Template - Isolated Design
 * Based on yacht-single-template.html
 */

get_header();

while (have_posts()) : the_post();

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

    // Enqueue Swiper
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '11.0.0');
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '11.0.0', true);
?>

<!-- ISOLATED YACHT SINGLE CONTAINER -->
<div class="yr-single-yacht-isolated-wrapper">
<style>
/* === COMPLETE CSS RESET FOR YACHT SINGLE PAGE === */
.yr-single-yacht-isolated-wrapper * {
    margin: 0 !important;
    padding: 0 !important;
    box-sizing: border-box !important;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
}

.yr-single-yacht-isolated-wrapper {
    background: #f5f5f5 !important;
    padding: 40px 20px !important;
    margin: 0 !important;
    width: 100% !important;
    float: none !important;
    clear: both !important;
}

.yr-yacht-container {
    max-width: 1200px !important;
    margin: 0 auto !important;
    padding: 40px 20px !important;
    background: transparent !important;
}

/* === TITLE SECTION === */
.yr-yacht-title {
    text-align: center !important;
    margin-bottom: 30px !important;
}

.yr-yacht-title h1 {
    font-size: 36px !important;
    color: #1a2332 !important;
    margin-bottom: 10px !important;
    font-weight: 700 !important;
    line-height: 1.2 !important;
}

.yr-rating {
    color: #ffa500 !important;
    font-size: 20px !important;
    line-height: 1 !important;
}

/* === GALLERY SLIDER === */
.yr-gallery-wrapper {
    margin-bottom: 40px !important;
}

.yr-gallery-row {
    position: relative !important;
    overflow: hidden !important;
    border-radius: 15px !important;
    box-shadow: 0 15px 60px rgba(0,0,0,0.25) !important;
    background: transparent !important;
}

.yr-gallery-swiper {
    width: 100% !important;
    height: 400px !important;
    background: transparent !important;
}

.yr-gallery-swiper .swiper-wrapper {
    margin: 0 !important;
    padding: 0 !important;
}

.yr-gallery-swiper .swiper-slide {
    display: grid !important;
    grid-template-columns: repeat(2, 1fr) !important;
    gap: 2px !important;
    padding: 0 !important;
    background: transparent !important;
    margin: 0 !important;
}

.yr-gallery-item {
    position: relative !important;
    overflow: hidden !important;
    border-radius: 0 !important;
    height: 400px !important;
    background: transparent !important;
    margin: 0 !important;
    padding: 0 !important;
}

.yr-gallery-item img {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    transition: transform 0.3s ease !important;
    display: block !important;
    margin: 0 !important;
    padding: 0 !important;
}

.yr-gallery-item:hover img {
    transform: scale(1.1) !important;
}

/* Swiper Navigation */
.yr-gallery-swiper .swiper-button-next,
.yr-gallery-swiper .swiper-button-prev {
    color: #fff !important;
    background: rgba(26, 35, 50, 0.8) !important;
    width: 45px !important;
    height: 45px !important;
    border-radius: 50% !important;
    transition: all 0.3s ease !important;
}

.yr-gallery-swiper .swiper-button-next:hover,
.yr-gallery-swiper .swiper-button-prev:hover {
    background: rgba(26, 35, 50, 1) !important;
    transform: scale(1.1) !important;
}

.yr-gallery-swiper .swiper-button-next:after,
.yr-gallery-swiper .swiper-button-prev:after {
    font-size: 20px !important;
    font-weight: bold !important;
}

.yr-gallery-swiper .swiper-pagination-bullet {
    background: #1a2332 !important;
    width: 12px !important;
    height: 12px !important;
    opacity: 0.5 !important;
}

.yr-gallery-swiper .swiper-pagination-bullet-active {
    background: #25d366 !important;
    opacity: 1 !important;
}

/* === PRICE SECTION === */
.yr-price-section {
    display: flex !important;
    gap: 20px !important;
    justify-content: center !important;
    margin-bottom: 30px !important;
    flex-wrap: wrap !important;
}

.yr-price-box {
    flex: 1 !important;
    max-width: 500px !important;
    text-align: center !important;
    padding: 25px 30px !important;
    border: none !important;
    border-radius: 12px !important;
    background: #fff !important;
    box-shadow: 0 8px 30px rgba(0,0,0,0.1) !important;
    transition: transform 0.3s ease !important;
}

.yr-price-box:hover {
    transform: translateY(-5px) !important;
    box-shadow: 0 12px 40px rgba(0,0,0,0.15) !important;
}

.yr-old-price {
    color: #ff0000 !important;
    font-size: 32px !important;
    font-weight: bold !important;
    text-decoration: line-through !important;
    margin-right: 10px !important;
    display: inline-block !important;
}

.yr-new-price {
    color: #ff0000 !important;
    font-size: 32px !important;
    font-weight: bold !important;
    display: inline-block !important;
}

.yr-price-label {
    color: #1a2332 !important;
    font-size: 22px !important;
    font-weight: 600 !important;
    display: block !important;
    margin-top: 5px !important;
}

/* === DESCRIPTION === */
.yr-description {
    text-align: center !important;
    font-size: 16px !important;
    line-height: 1.8 !important;
    color: #555 !important;
    margin-bottom: 30px !important;
    padding: 30px !important;
    background: #fff !important;
    border-radius: 12px !important;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08) !important;
}

.yr-description p {
    margin: 0 !important;
    padding: 0 !important;
}

/* === CTA BUTTONS === */
.yr-cta-buttons {
    display: flex !important;
    gap: 20px !important;
    justify-content: center !important;
    margin-bottom: 50px !important;
    flex-wrap: wrap !important;
}

.yr-btn {
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
}

.yr-btn-whatsapp {
    background: #25d366 !important;
    color: #fff !important;
}

.yr-btn-whatsapp:hover {
    background: #1fb855 !important;
    transform: translateY(-3px) !important;
    box-shadow: 0 10px 30px rgba(37, 211, 102, 0.4) !important;
    color: #fff !important;
}

.yr-btn-call {
    background: #1a2332 !important;
    color: #fff !important;
}

.yr-btn-call:hover {
    background: #2d3e50 !important;
    transform: translateY(-3px) !important;
    box-shadow: 0 10px 30px rgba(26, 35, 50, 0.4) !important;
    color: #fff !important;
}

/* === FEATURES SECTION === */
.yr-features-section {
    display: grid !important;
    grid-template-columns: repeat(2, 1fr) !important;
    gap: 30px !important;
    margin-top: 50px !important;
    margin-bottom: 50px !important;
}

.yr-features-column {
    background: #fff !important;
    padding: 35px !important;
    border-radius: 15px !important;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1) !important;
    transition: all 0.3s ease !important;
    border: 2px solid transparent !important;
}

.yr-features-column:hover {
    transform: translateY(-5px) !important;
    box-shadow: 0 15px 50px rgba(0,0,0,0.15) !important;
    border-color: #25d366 !important;
}

.yr-features-column h2 {
    font-size: 26px !important;
    color: #1a2332 !important;
    margin-bottom: 25px !important;
    font-weight: 700 !important;
    position: relative !important;
    padding-bottom: 15px !important;
}

.yr-features-column h2:after {
    content: '' !important;
    position: absolute !important;
    left: 0 !important;
    bottom: 0 !important;
    width: 60px !important;
    height: 4px !important;
    background: linear-gradient(90deg, #25d366, #1fb855) !important;
    border-radius: 2px !important;
}

.yr-feature-list {
    list-style: none !important;
    margin: 0 !important;
    padding: 0 !important;
}

.yr-feature-list li {
    padding: 12px 0 !important;
    padding-left: 40px !important;
    position: relative !important;
    font-size: 15px !important;
    line-height: 1.7 !important;
    color: #555 !important;
    transition: all 0.2s ease !important;
    margin: 0 !important;
}

.yr-feature-list li:hover {
    color: #1a2332 !important;
    transform: translateX(5px) !important;
}

.yr-feature-list li:before {
    content: "✓" !important;
    position: absolute !important;
    left: 0 !important;
    top: 10px !important;
    width: 28px !important;
    height: 28px !important;
    background: linear-gradient(135deg, #25d366, #1fb855) !important;
    color: #fff !important;
    border-radius: 50% !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-weight: bold !important;
    font-size: 14px !important;
    box-shadow: 0 3px 10px rgba(37, 211, 102, 0.3) !important;
}

/* === FAQ SECTION === */
.yr-faq-section {
    margin-top: 60px !important;
    margin-bottom: 40px !important;
}

.yr-faq-title {
    text-align: center !important;
    font-size: 32px !important;
    color: #1a2332 !important;
    margin-bottom: 40px !important;
    font-weight: 700 !important;
}

.yr-faq-container {
    max-width: 900px !important;
    margin: 0 auto !important;
}

.yr-faq-item {
    background: #fff !important;
    margin-bottom: 15px !important;
    border-radius: 12px !important;
    overflow: hidden !important;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08) !important;
    transition: all 0.3s ease !important;
}

.yr-faq-item:hover {
    box-shadow: 0 8px 30px rgba(0,0,0,0.12) !important;
}

.yr-faq-question {
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

.yr-faq-question:hover {
    background: #f8f9fa !important;
    color: #25d366 !important;
}

.yr-faq-question.active {
    background: #f0f9f4 !important;
    color: #25d366 !important;
}

.yr-faq-icon {
    font-size: 20px !important;
    font-weight: bold !important;
    transition: transform 0.3s ease !important;
    color: #25d366 !important;
    margin: 0 !important;
    padding: 0 !important;
}

.yr-faq-question.active .yr-faq-icon {
    transform: rotate(45deg) !important;
}

.yr-faq-answer {
    max-height: 0 !important;
    overflow: hidden !important;
    transition: max-height 0.3s ease, padding 0.3s ease !important;
    padding: 0 25px !important;
    color: #666 !important;
    line-height: 1.7 !important;
    font-size: 15px !important;
}

.yr-faq-answer.active {
    max-height: 500px !important;
    padding: 15px 25px 20px !important;
}

.yr-faq-answer p {
    margin: 0 !important;
    padding: 0 !important;
}

/* === RESPONSIVE === */
@media (max-width: 768px) {
    .yr-yacht-title h1 {
        font-size: 28px !important;
    }

    .yr-gallery-swiper {
        height: auto !important;
    }

    .yr-gallery-swiper .swiper-slide {
        grid-template-columns: 1fr !important;
    }

    .yr-gallery-item {
        height: 250px !important;
    }

    .yr-features-section {
        grid-template-columns: 1fr !important;
    }

    .yr-price-section {
        flex-direction: column !important;
    }

    .yr-cta-buttons {
        flex-direction: column !important;
    }

    .yr-btn {
        width: 100% !important;
        justify-content: center !important;
    }

    .yr-faq-title {
        font-size: 26px !important;
    }

    .yr-faq-question {
        font-size: 15px !important;
        padding: 15px 20px !important;
    }
}
</style>

<div class="yr-yacht-container">

    <!-- Title -->
    <div class="yr-yacht-title">
        <h1><?php the_title(); ?></h1>
        <div class="yr-rating">★★★★★</div>
    </div>

    <!-- Gallery Slider -->
    <?php if (!empty($gallery_ids) && count($gallery_ids) > 0): ?>
    <div class="yr-gallery-wrapper">
        <div class="yr-gallery-row">
            <div class="swiper yr-gallery-swiper">
                <div class="swiper-wrapper">
                    <?php
                    // Group images by 2 (2 images per slide)
                    $chunks = array_chunk($gallery_ids, 2);
                    foreach ($chunks as $chunk):
                    ?>
                        <div class="swiper-slide">
                            <?php foreach ($chunk as $image_id): ?>
                                <div class="yr-gallery-item">
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

    <!-- Price Section -->
    <?php if ($old_price || $new_price): ?>
    <div class="yr-price-section">
        <?php if ($old_price): ?>
            <div class="yr-price-box">
                <span class="yr-old-price"><?php echo esc_html($old_price); ?></span>
                <?php if ($price_label): ?>
                    <span class="yr-price-label"><?php echo esc_html($price_label); ?></span>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($new_price): ?>
            <div class="yr-price-box">
                <span class="yr-new-price">NOW - <?php echo esc_html($new_price); ?></span>
                <?php if ($price_label): ?>
                    <span class="yr-price-label"><?php echo esc_html($price_label); ?></span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <!-- Description -->
    <?php if (get_the_content()): ?>
    <div class="yr-description">
        <?php the_content(); ?>
    </div>
    <?php endif; ?>

    <!-- CTA Buttons -->
    <?php if ($whatsapp || $phone): ?>
    <div class="yr-cta-buttons">
        <?php if ($whatsapp): ?>
            <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $whatsapp)); ?>"
               class="yr-btn yr-btn-whatsapp" target="_blank">
                <span>📱</span> WHATSAPP US
            </a>
        <?php endif; ?>

        <?php if ($phone): ?>
            <a href="tel:<?php echo esc_attr($phone); ?>" class="yr-btn yr-btn-call">
                <span>📞</span> CALL US
            </a>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <!-- Features Section -->
    <?php if ((!empty($features) && is_array($features)) || (!empty($offers) && is_array($offers))): ?>
    <div class="yr-features-section">

        <!-- Left Column: Key Features -->
        <?php if (!empty($features) && is_array($features)): ?>
        <div class="yr-features-column">
            <h2>Key Features of <?php the_title(); ?></h2>
            <ul class="yr-feature-list">
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
        <div class="yr-features-column">
            <h2>We also Offer:</h2>
            <ul class="yr-feature-list">
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
    <div class="yr-faq-section">
        <h2 class="yr-faq-title">Frequently Asked Questions</h2>
        <div class="yr-faq-container">

            <?php foreach ($faq as $index => $item): ?>
                <?php if (!empty($item['question']) && !empty($item['answer'])): ?>
                    <div class="yr-faq-item">
                        <div class="yr-faq-question">
                            <span><?php echo esc_html($item['question']); ?></span>
                            <span class="yr-faq-icon">+</span>
                        </div>
                        <div class="yr-faq-answer">
                            <p><?php echo esc_html($item['answer']); ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>

        </div>
    </div>
    <?php endif; ?>

</div>

</div>
<!-- END ISOLATED WRAPPER -->

<script>
jQuery(document).ready(function($) {
    // Initialize gallery slider
    <?php if (!empty($gallery_ids) && count($gallery_ids) > 0): ?>
    var yrGallerySwiper = new Swiper('.yr-gallery-swiper', {
        slidesPerView: 1,
        spaceBetween: 0,
        navigation: {
            nextEl: '.yr-gallery-swiper .swiper-button-next',
            prevEl: '.yr-gallery-swiper .swiper-button-prev',
        },
        pagination: {
            el: '.yr-gallery-swiper .swiper-pagination',
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
    $('.yr-faq-question').on('click', function() {
        var $this = $(this);
        var $faqItem = $this.closest('.yr-faq-item');
        var $answer = $this.next('.yr-faq-answer');

        // Close other open items
        $('.yr-faq-item').not($faqItem).find('.yr-faq-question').removeClass('active');
        $('.yr-faq-item').not($faqItem).find('.yr-faq-answer').removeClass('active');

        // Toggle current item
        $this.toggleClass('active');
        $answer.toggleClass('active');
    });
});
</script>

<?php
endwhile;

get_footer();
