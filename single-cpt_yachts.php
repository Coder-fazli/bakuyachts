<?php
/**
 * Single Yacht Template
 */

get_header();

while (have_posts()) : the_post();

    // Get meta data
    $gallery = get_post_meta(get_the_ID(), '_yr_yacht_gallery', true);
    $gallery_ids = !empty($gallery) ? explode(',', $gallery) : array();

    $old_price = get_post_meta(get_the_ID(), '_yr_yacht_old_price', true);
    $new_price = get_post_meta(get_the_ID(), '_yr_yacht_new_price', true);
    $price_label = get_post_meta(get_the_ID(), '_yr_yacht_price_label', true);

    $whatsapp = get_post_meta(get_the_ID(), '_yr_yacht_whatsapp', true);
    $phone = get_post_meta(get_the_ID(), '_yr_yacht_phone', true);

    $price_per_hour = get_post_meta(get_the_ID(), '_yr_yacht_price', true);
    $length = get_post_meta(get_the_ID(), '_yr_yacht_length', true);
    $cabins = get_post_meta(get_the_ID(), '_yr_yacht_cabins', true);
    $max_guests = get_post_meta(get_the_ID(), '_yr_yacht_max_guests', true);

    $features = get_post_meta(get_the_ID(), '_yr_yacht_features', true);
    $offers = get_post_meta(get_the_ID(), '_yr_yacht_offers', true);
    $faq = get_post_meta(get_the_ID(), '_yr_yacht_faq', true);
?>

<div class="yr_single_yacht_page">

    <!-- Title Section -->
    <div class="yr_yacht_title_section">
        <div class="yr_container_wide">
            <h1 class="yr_yacht_main_title"><?php the_title(); ?></h1>
        </div>
    </div>

    <!-- Gallery Slider -->
    <?php if (!empty($gallery_ids) && count($gallery_ids) > 0): ?>
    <div class="yr_gallery_section">
        <div class="yr_container_wide">
            <div class="swiper yr_yacht_gallery_swiper">
                <div class="swiper-wrapper">
                    <?php
                    // Group images by 2 (for 2-column grid per slide)
                    $chunks = array_chunk($gallery_ids, 2);
                    foreach ($chunks as $chunk):
                    ?>
                        <div class="swiper-slide">
                            <div class="yr_slide_grid">
                                <?php foreach ($chunk as $image_id): ?>
                                    <div class="yr_slide_image">
                                        <?php echo wp_get_attachment_image($image_id, 'full'); ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
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

    <!-- Main Content Container -->
    <div class="yr_container">

        <!-- Price Section -->
        <?php if ($old_price || $new_price): ?>
        <div class="yr_price_section">
            <?php if ($old_price): ?>
                <div class="yr_price_card">
                    <span class="yr_old_price_display"><?php echo esc_html($old_price); ?></span>
                    <?php if ($price_label): ?>
                        <span class="yr_price_label_text"><?php echo esc_html($price_label); ?></span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php if ($new_price): ?>
                <div class="yr_price_card yr_price_card_new">
                    <span class="yr_new_price_display">NOW - <?php echo esc_html($new_price); ?></span>
                    <?php if ($price_label): ?>
                        <span class="yr_price_label_text"><?php echo esc_html($price_label); ?></span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Description -->
        <?php if (get_the_content()): ?>
        <div class="yr_description_section">
            <?php the_content(); ?>
        </div>
        <?php endif; ?>

        <!-- CTA Buttons -->
        <?php if ($whatsapp || $phone): ?>
        <div class="yr_cta_section">
            <?php if ($whatsapp): ?>
                <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $whatsapp)); ?>"
                   class="yr_cta_button yr_cta_whatsapp" target="_blank">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    WHATSAPP US
                </a>
            <?php endif; ?>
            <?php if ($phone): ?>
                <a href="tel:<?php echo esc_attr($phone); ?>" class="yr_cta_button yr_cta_call">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                    </svg>
                    CALL US
                </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Features Section -->
        <?php if ((!empty($features) && is_array($features)) || (!empty($offers) && is_array($offers))): ?>
        <div class="yr_features_wrapper">

            <!-- Key Features -->
            <?php if (!empty($features) && is_array($features)): ?>
            <div class="yr_feature_box">
                <h2 class="yr_feature_heading">Key Features of <?php the_title(); ?></h2>
                <ul class="yr_feature_items">
                    <?php foreach ($features as $feature): ?>
                        <?php if (!empty($feature)): ?>
                            <li><?php echo esc_html($feature); ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <!-- We Also Offer -->
            <?php if (!empty($offers) && is_array($offers)): ?>
            <div class="yr_feature_box">
                <h2 class="yr_feature_heading">We also Offer:</h2>
                <ul class="yr_feature_items">
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
        <div class="yr_faq_wrapper">
            <h2 class="yr_faq_main_title">Frequently Asked Questions</h2>
            <div class="yr_faq_list">
                <?php foreach ($faq as $index => $item): ?>
                    <?php if (!empty($item['question']) && !empty($item['answer'])): ?>
                        <div class="yr_faq_block">
                            <div class="yr_faq_q">
                                <span><?php echo esc_html($item['question']); ?></span>
                                <span class="yr_faq_toggle">+</span>
                            </div>
                            <div class="yr_faq_a">
                                <?php echo wpautop(esc_html($item['answer'])); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Swiper
    <?php if (!empty($gallery_ids) && count($gallery_ids) > 0): ?>
    const swiper = new Swiper('.yr_yacht_gallery_swiper', {
        slidesPerView: 1,
        spaceBetween: 0,
        loop: <?php echo count($gallery_ids) > 2 ? 'true' : 'false'; ?>,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
    });
    <?php endif; ?>

    // FAQ Accordion
    const faqQuestions = document.querySelectorAll('.yr_faq_q');
    faqQuestions.forEach(function(question) {
        question.addEventListener('click', function() {
            const faqBlock = this.closest('.yr_faq_block');
            const isActive = faqBlock.classList.contains('active');

            // Close all items
            document.querySelectorAll('.yr_faq_block').forEach(function(block) {
                block.classList.remove('active');
            });

            // Open clicked item if it wasn't active
            if (!isActive) {
                faqBlock.classList.add('active');
            }
        });
    });
});
</script>

<?php
endwhile;

get_footer();
