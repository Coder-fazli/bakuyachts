<?php
/**
 * About Page Shortcode
 *
 * Usage: [yacht_about]
 * Place this shortcode on any page to display the About content.
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0
 */

// Register the shortcode
function yacht_rental_about_shortcode() {
    // Build query args
    $query_args = array(
        'post_type' => 'about',
        'posts_per_page' => 1,
        'post_status' => 'publish',
    );

    // Add language filter if Polylang is active
    if ( function_exists( 'pll_current_language' ) ) {
        $current_lang = pll_current_language();
        if ( $current_lang ) {
            $query_args['lang'] = $current_lang;
        }
    }

    // Get the About post for current language
    $about_query = new WP_Query( $query_args );

    if ( ! $about_query->have_posts() ) {
        return '<div style="padding: 50px 20px; text-align: center; font-family: sans-serif;">
            <p style="color: #666;">About content not configured. Go to <strong>About → Add New</strong> in WordPress admin.</p>
        </div>';
    }

    $about_query->the_post();
    $about_id = get_the_ID();

    // Hero Section
    $hero_heading = get_the_title();
    $hero_subheading = get_post_meta( $about_id, '_yr_hero_subheading', true );
    $hero_content = get_post_meta( $about_id, '_yr_hero_content', true );
    $stats_yachts = get_post_meta( $about_id, '_yr_stats_yachts', true );
    $stats_voyages = get_post_meta( $about_id, '_yr_stats_voyages', true );
    $stats_concierge = get_post_meta( $about_id, '_yr_stats_concierge', true );
    // Stat labels (with defaults)
    $stats_yachts_label = get_post_meta( $about_id, '_yr_stats_yachts_label', true );
    $stats_voyages_label = get_post_meta( $about_id, '_yr_stats_voyages_label', true );
    $stats_concierge_label = get_post_meta( $about_id, '_yr_stats_concierge_label', true );
    if ( empty( $stats_yachts_label ) ) $stats_yachts_label = __( 'Luxury Yachts', 'yacht-rental' );
    if ( empty( $stats_voyages_label ) ) $stats_voyages_label = __( 'Voyages Delivered', 'yacht-rental' );
    if ( empty( $stats_concierge_label ) ) $stats_concierge_label = __( 'VIP Concierge', 'yacht-rental' );
    $hero_image = has_post_thumbnail() ? get_the_post_thumbnail_url( $about_id, 'large' ) : 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?q=80&w=2069&auto=format&fit=crop';

    // Founder Section
    $founder_image_id  = get_post_meta( $about_id, '_yr_founder_image_id', true );
    $founder_image_url = $founder_image_id ? wp_get_attachment_image_url( $founder_image_id, 'large' ) : '';
    $founder_image_alt = $founder_image_id ? get_post_meta( $founder_image_id, '_wp_attachment_image_alt', true ) : '';
    $founder_subtitle  = get_post_meta( $about_id, '_yr_founder_subtitle', true );
    $founder_title     = get_post_meta( $about_id, '_yr_founder_title', true );
    $founder_text      = get_post_meta( $about_id, '_yr_founder_text', true );
    $founder_name      = get_post_meta( $about_id, '_yr_founder_name', true );
    $founder_role      = get_post_meta( $about_id, '_yr_founder_role', true );

    // Reviews
    $reviews_title = get_post_meta( $about_id, '_yr_reviews_title', true );
    if ( empty( $reviews_title ) ) {
        $reviews_title = __( 'Voyager Stories', 'yacht-rental' );
    }
    $reviews = get_post_meta( $about_id, '_yr_reviews', true );
    if ( ! is_array( $reviews ) ) {
        $reviews = array();
    }

    wp_reset_postdata();

    // Start output buffering
    ob_start();
    ?>

<!-- Required Assets -->
<script src="https://cdn.tailwindcss.com"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
/* Reset and full-width container */
.yr-about-section {
    --soft-blue: #EEF7FD;
    font-family: 'Inter', sans-serif !important;
    background-color: #FFFFFF;
    color: #111111;
    overflow-x: hidden;
    width: 100vw;
    position: relative;
    left: 50%;
    right: 50%;
    margin-left: -50vw;
    margin-right: -50vw;
    margin-top: -150px;
    box-sizing: border-box;
    line-height: 1.5;
}
/* Remove extra padding from hero section */
.yr-about-section .pt-40 {
    padding-top: 0.5rem !important;
}
.yr-about-section .pb-24 {
    padding-bottom: 1rem !important;
}
@media (min-width: 768px) {
    .yr-about-section .md\:pt-60 {
        padding-top: 0.75rem !important;
    }
    .yr-about-section .md\:pb-40 {
        padding-bottom: 1.5rem !important;
    }
}
.yr-about-section * {
    box-sizing: border-box;
}

/* Fix Font Awesome Icons */
.yr-about-section .fas,
.yr-about-section .fa-arrow-left,
.yr-about-section .fa-arrow-right,
.yr-about-section .fa-star {
    font-family: "Font Awesome 6 Free" !important;
    font-weight: 900 !important;
    font-style: normal !important;
    -webkit-font-smoothing: antialiased;
    display: inline-block;
}
.yr-about-section .fa-arrow-left:before {
    content: "\f060" !important;
}
.yr-about-section .fa-arrow-right:before {
    content: "\f061" !important;
}
.yr-about-section .fa-star:before {
    content: "\f005" !important;
}
.yr-about-section img {
    max-width: 100%;
    height: auto;
}
.yr-about-section h1,
.yr-about-section h2,
.yr-about-section h4,
.yr-about-section h5,
.yr-about-section p {
    margin: 0;
    padding: 0;
}
.yr-about-section .bg-soft-blue { background-color: var(--soft-blue); }

/* Smooth reveal animation */
.yr-about-section .reveal {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.8s cubic-bezier(0.2, 1, 0.3, 1);
}
.yr-about-section .reveal.active {
    opacity: 1;
    transform: translateY(0);
}

/* Review Slider */
.yr-about-section #review-slider-track {
    display: flex;
    transition: transform 0.6s cubic-bezier(0.65, 0, 0.35, 1);
}
.yr-about-section .review-group {
    flex: 0 0 100%;
}

/* Premium spacing for wider layout gutters */
.yr-about-section .container-wide {
    width: 100%;
    margin-right: auto;
    margin-left: auto;
    padding-right: 1.5rem;
    padding-left: 1.5rem;
}
@media (min-width: 640px) {
    .yr-about-section .container-wide { padding-right: 3rem; padding-left: 3rem; }
}
@media (min-width: 1024px) {
    .yr-about-section .container-wide { padding-right: 6rem; padding-left: 6rem; }
}
@media (min-width: 1280px) {
    .yr-about-section .container-wide { padding-right: 10rem; padding-left: 10rem; }
}

/* Text selection styling */
.yr-about-section ::selection {
    background-color: #dbeafe;
    color: #1e3a5f;
}

/* Hero section - override theme styles */
.yr-about-section .aspect-\[4\/5\] {
    aspect-ratio: 4 / 5 !important;
    position: relative !important;
}
.yr-about-section .aspect-\[4\/5\] img {
    position: absolute !important;
    inset: 0 !important;
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
}
.yr-about-section .w-full.md\:w-1\/2 {
    width: 100% !important;
}
@media (min-width: 768px) {
    .yr-about-section .md\:w-1\/2 {
        width: 50% !important;
    }
}
.yr-about-section .-inset-4 {
    inset: -1rem !important;
}
.yr-about-section .translate-x-8 {
    transform: translateX(2rem) translateY(2rem) !important;
}

/* Hero content typography - force original sizes */
.yr-about-section h1 {
    font-size: 3rem !important;
    line-height: 1 !important;
    font-weight: 700 !important;
    letter-spacing: -0.025em !important;
    margin-bottom: 2.5rem !important;
}
@media (min-width: 768px) {
    .yr-about-section h1 {
        font-size: 6rem !important;
    }
}
.yr-about-section h4 {
    font-size: 10px !important;
    font-weight: 700 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.3em !important;
    color: #3b82f6 !important;
    margin-bottom: 1.5rem !important;
}
.yr-about-section .text-lg {
    font-size: 1.125rem !important;
    line-height: 1.75 !important;
    color: #6b7280 !important;
    margin-bottom: 3rem !important;
}
.yr-about-section .text-2xl {
    font-size: 1.5rem !important;
}
@media (min-width: 768px) {
    .yr-about-section .md\:text-3xl {
        font-size: 1.875rem !important;
    }
}
.yr-about-section .gap-16 {
    gap: 4rem !important;
}
@media (min-width: 768px) {
    .yr-about-section .md\:gap-24 {
        gap: 6rem !important;
    }
}
</style>

<div class="yr-about-section">
    <!-- Hero Section -->
    <section class="relative pt-40 pb-24 md:pt-60 md:pb-40 overflow-hidden">
        <div class="container-wide">
            <div class="flex flex-col md:flex-row items-center gap-16 md:gap-24">
                <div class="w-full md:w-1/2 reveal">
                    <h4 class="text-blue-500 font-bold uppercase tracking-[0.3em] text-[10px] mb-6"><?php echo esc_html( $hero_subheading ); ?></h4>
                    <h1 class="text-5xl md:text-8xl font-bold leading-[1] mb-10 tracking-tight">
                        <?php echo wp_kses_post( $hero_heading ); ?>
                    </h1>
                    <p class="text-lg text-gray-500 max-w-lg mb-12 leading-relaxed font-light">
                        <?php echo esc_html( $hero_content ); ?>
                    </p>

                    <!-- Statistics Row -->
                    <div class="flex flex-wrap items-center gap-6 sm:gap-10">
                        <div class="flex flex-col">
                            <span class="text-2xl md:text-3xl font-bold text-black tracking-tighter"><?php echo esc_html( $stats_yachts ); ?></span>
                            <span class="text-[8px] sm:text-[9px] uppercase tracking-widest text-gray-400 font-bold mt-1"><?php echo esc_html( $stats_yachts_label ); ?></span>
                        </div>
                        <div class="h-8 w-px bg-gray-200 hidden sm:block"></div>
                        <div class="flex flex-col">
                            <span class="text-2xl md:text-3xl font-bold text-black tracking-tighter"><?php echo esc_html( $stats_voyages ); ?></span>
                            <span class="text-[8px] sm:text-[9px] uppercase tracking-widest text-gray-400 font-bold mt-1"><?php echo esc_html( $stats_voyages_label ); ?></span>
                        </div>
                        <div class="h-8 w-px bg-gray-200 hidden sm:block"></div>
                        <div class="flex flex-col">
                            <span class="text-2xl md:text-3xl font-bold text-black tracking-tighter"><?php echo esc_html( $stats_concierge ); ?></span>
                            <span class="text-[8px] sm:text-[9px] uppercase tracking-widest text-gray-400 font-bold mt-1"><?php echo esc_html( $stats_concierge_label ); ?></span>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-1/2 relative reveal" style="transition-delay: 200ms;">
                    <div class="absolute -inset-4 bg-soft-blue -z-10 rounded-3xl translate-x-8 translate-y-8"></div>
                    <div class="aspect-[4/5] overflow-hidden rounded-2xl shadow-2xl group">
                        <img
                            src="<?php echo esc_url( $hero_image ); ?>"
                            alt="Luxury Yacht Experience"
                            class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-1000 scale-105 group-hover:scale-100"
                        />
                    </div>
                    <!-- Trust Badge -->
                    <div class="absolute -bottom-10 -left-10 bg-white p-8 shadow-xl rounded-lg hidden lg:block border border-gray-50">
                        <div class="flex items-center space-x-4 mb-2">
                            <div class="flex -space-x-2">
                                <img src="https://i.pravatar.cc/100?u=a" class="w-8 h-8 rounded-full border-2 border-white" alt="avatar">
                                <img src="https://i.pravatar.cc/100?u=b" class="w-8 h-8 rounded-full border-2 border-white" alt="avatar">
                                <img src="https://i.pravatar.cc/100?u=c" class="w-8 h-8 rounded-full border-2 border-white" alt="avatar">
                            </div>
                            <span class="text-[10px] font-bold uppercase tracking-widest text-blue-600">Rated 4.9/5</span>
                        </div>
                        <p class="text-[11px] text-gray-400 font-medium italic">"The benchmark of maritime luxury."</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php if ( $founder_title || $founder_image_url ) : ?>
    <!-- Founder Section -->
    <section class="yr-founder-section" style="padding:100px 0; background:#fff; overflow:hidden;">
        <div class="container-wide" style="display:flex; align-items:stretch; gap:80px;">

            <?php if ( $founder_image_url ) : ?>
            <div style="flex:0 0 420px; max-width:420px; position:relative;">
                <div style="position:absolute; top:30px; left:-20px; width:100%; height:100%; border:2px solid #c9a96e; border-radius:4px; z-index:0;"></div>
                <img src="<?php echo esc_url( $founder_image_url ); ?>" alt="<?php echo esc_attr( $founder_image_alt ?: $founder_name ); ?>"
                    style="position:relative; z-index:1; width:100%; height:100%; object-fit:cover; object-position:top center; border-radius:4px; min-height:560px; display:block;">
            </div>
            <?php endif; ?>

            <div style="flex:1; display:flex; flex-direction:column; justify-content:center; padding:20px 0;">
                <?php if ( $founder_subtitle ) : ?>
                    <span style="font-size:13px; font-weight:600; letter-spacing:3px; text-transform:uppercase; color:#c9a96e; margin-bottom:16px; display:block;"><?php echo esc_html( $founder_subtitle ); ?></span>
                <?php endif; ?>

                <?php if ( $founder_title ) : ?>
                    <h2 style="font-size:clamp(28px,3.5vw,46px); font-weight:700; line-height:1.15; color:#0a0a0a; margin:0 0 28px;"><?php echo esc_html( $founder_title ); ?></h2>
                <?php endif; ?>

                <?php if ( $founder_text ) : ?>
                    <div style="font-size:16px; line-height:1.85; color:#555; margin-bottom:40px;"><?php echo wp_kses_post( wpautop( $founder_text ) ); ?></div>
                <?php endif; ?>

                <?php if ( $founder_name || $founder_role ) : ?>
                <div style="display:flex; align-items:center; gap:16px; padding-top:32px; border-top:1px solid #e8e8e8;">
                    <div style="width:40px; height:2px; background:#c9a96e; flex-shrink:0;"></div>
                    <div>
                        <?php if ( $founder_name ) : ?>
                            <p style="font-size:18px; font-weight:700; color:#0a0a0a; margin:0; line-height:1.3;"><?php echo esc_html( $founder_name ); ?></p>
                        <?php endif; ?>
                        <?php if ( $founder_role ) : ?>
                            <p style="font-size:13px; color:#888; letter-spacing:1px; text-transform:uppercase; margin:4px 0 0;"><?php echo esc_html( $founder_role ); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

        </div>
    </section>
    <style>
    @media (max-width: 768px) {
        .yr-founder-section .container-wide { flex-direction: column !important; gap: 40px !important; }
        .yr-founder-section .container-wide > div:first-child { flex: none !important; max-width: 100% !important; }
        .yr-founder-section .container-wide > div:first-child > div { display: none !important; }
        .yr-founder-section .container-wide > div:first-child img { min-height: 380px !important; }
    }
    </style>
    <?php endif; ?>

    <!-- Partners Logo Carousel -->
    <?php echo do_shortcode( '[partners_slider]' ); ?>

    <?php if ( ! empty( $reviews ) ) : ?>
    <!-- Voyager Reviews -->
    <section class="py-16 md:py-20 bg-white overflow-hidden">
        <div class="container-wide">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-8 reveal">
                <div class="max-w-xl">
                    <h2 class="text-3xl md:text-5xl font-bold tracking-tight mb-4"><?php echo esc_html( $reviews_title ); ?></h2>
                    <div class="h-1 w-24 bg-blue-500"></div>
                </div>
                <div class="flex space-x-4">
                    <button id="yr-slider-prev" class="w-14 h-14 rounded-full border border-gray-100 flex items-center justify-center hover:bg-soft-blue hover:text-blue-600 transition-all text-gray-400">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <button id="yr-slider-next" class="w-14 h-14 rounded-full border border-gray-100 flex items-center justify-center hover:bg-soft-blue hover:text-blue-600 transition-all text-gray-400">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <div class="relative overflow-hidden reveal">
                <div id="review-slider-track">
                    <?php
                    // Group reviews in pairs (2 per slide)
                    $review_pairs = array_chunk( $reviews, 2 );

                    foreach ( $review_pairs as $pair ) :
                    ?>
                    <div class="review-group grid md:grid-cols-2 gap-6 px-2">
                        <?php foreach ( $pair as $index => $review ) :
                            // Alternate styles: first card blue bg, second card white with border
                            $card_class = ( $index === 0 ) ? 'bg-soft-blue' : 'bg-white border border-gray-100 shadow-sm';
                            $photo = ! empty( $review['photo'] ) ? $review['photo'] : 'https://i.pravatar.cc/100?u=' . sanitize_title( $review['name'] );
                        ?>
                        <div class="<?php echo esc_attr( $card_class ); ?> p-8 md:p-10 rounded-3xl">
                            <div class="flex text-blue-400 mb-6 space-x-1">
                                <i class="fas fa-star text-xs"></i><i class="fas fa-star text-xs"></i><i class="fas fa-star text-xs"></i><i class="fas fa-star text-xs"></i><i class="fas fa-star text-xs"></i>
                            </div>
                            <p class="text-base font-medium text-gray-800 mb-8 leading-relaxed italic" style="font-size: 16px !important;">
                                "<?php echo esc_html( $review['text'] ); ?>"
                            </p>
                            <div class="flex items-center space-x-5">
                                <img src="<?php echo esc_url( $photo ); ?>" class="w-14 h-14 rounded-full grayscale object-cover" alt="<?php echo esc_attr( $review['name'] ); ?>">
                                <div>
                                    <h5 class="font-bold text-sm uppercase tracking-wider"><?php echo esc_html( $review['name'] ); ?></h5>
                                    <p class="text-[10px] uppercase tracking-widest text-gray-400 mt-1 font-bold"><?php echo esc_html( $review['subtitle'] ); ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Reveal on scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) entry.target.classList.add('active');
        });
    }, { threshold: 0.1 });
    document.querySelectorAll('.yr-about-section .reveal').forEach(el => observer.observe(el));

    // Slider logic
    const track = document.getElementById('review-slider-track');
    const prevBtn = document.getElementById('yr-slider-prev');
    const nextBtn = document.getElementById('yr-slider-next');

    if (track && prevBtn && nextBtn) {
        let currentIdx = 0;
        const totalSlides = document.querySelectorAll('.yr-about-section .review-group').length;

        const updateSlider = () => track.style.transform = `translateX(-${currentIdx * 100}%)`;
        nextBtn.addEventListener('click', () => { currentIdx = (currentIdx + 1) % totalSlides; updateSlider(); });
        prevBtn.addEventListener('click', () => { currentIdx = (currentIdx - 1 + totalSlides) % totalSlides; updateSlider(); });

        // Auto cycle slider
        if (totalSlides > 1) {
            setInterval(() => { currentIdx = (currentIdx + 1) % totalSlides; updateSlider(); }, 10000);
        }
    }
});
</script>

    <?php
    return ob_get_clean();
}
add_shortcode( 'yacht_about', 'yacht_rental_about_shortcode' );
