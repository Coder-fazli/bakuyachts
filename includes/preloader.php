<?php
/**
 * Preloader Component
 *
 * Displays a minimalist preloader with wave effects while the page loads
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Add preloader HTML to the body
 */
if ( ! function_exists( 'yacht_rental_preloader_html' ) ) {
    add_action( 'wp_body_open', 'yacht_rental_preloader_html' );

    function yacht_rental_preloader_html() {
        ?>
        <div id="yr-preloader" class="yr-preloader">
            <div class="yr-preloader-waves">
                <div class="yr-wave yr-wave-1"></div>
                <div class="yr-wave yr-wave-2"></div>
                <div class="yr-wave yr-wave-3"></div>
            </div>
            <div class="yr-preloader-inner">
                <img src="<?php echo esc_url( YACHT_RENTAL_THEME_URL . '7308549.gif' ); ?>" alt="Loading..." class="yr-preloader-gif">
            </div>
        </div>
        <?php
    }
}

/**
 * Add preloader styles
 */
if ( ! function_exists( 'yacht_rental_preloader_styles' ) ) {
    add_action( 'wp_head', 'yacht_rental_preloader_styles', 1 );

    function yacht_rental_preloader_styles() {
        ?>
        <style id="yr-preloader-styles">
            .yr-preloader {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: linear-gradient(180deg, #ffffff 0%, #f0f9ff 50%, #e6f4ff 100%);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 999999;
                transition: opacity 0.3s ease, visibility 0.3s ease;
                overflow: hidden;
            }
            .yr-preloader.yr-preloader-hidden {
                opacity: 0;
                visibility: hidden;
                pointer-events: none;
            }
            .yr-preloader-waves {
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                height: 40%;
                overflow: hidden;
            }
            .yr-wave {
                position: absolute;
                bottom: 0;
                left: 0;
                width: 200%;
                height: 100%;
                background-repeat: repeat-x;
                transform-origin: center bottom;
            }
            .yr-wave-1 {
                background: linear-gradient(90deg,
                    transparent 0%,
                    rgba(0, 174, 239, 0.08) 25%,
                    rgba(0, 174, 239, 0.12) 50%,
                    rgba(0, 174, 239, 0.08) 75%,
                    transparent 100%);
                height: 60%;
                animation: yr-wave-move 8s linear infinite;
                border-radius: 50% 50% 0 0;
            }
            .yr-wave-2 {
                background: linear-gradient(90deg,
                    transparent 0%,
                    rgba(0, 174, 239, 0.05) 25%,
                    rgba(0, 174, 239, 0.08) 50%,
                    rgba(0, 174, 239, 0.05) 75%,
                    transparent 100%);
                height: 50%;
                animation: yr-wave-move 12s linear infinite reverse;
                border-radius: 50% 50% 0 0;
            }
            .yr-wave-3 {
                background: linear-gradient(90deg,
                    transparent 0%,
                    rgba(0, 174, 239, 0.03) 25%,
                    rgba(0, 174, 239, 0.06) 50%,
                    rgba(0, 174, 239, 0.03) 75%,
                    transparent 100%);
                height: 70%;
                animation: yr-wave-move 15s linear infinite;
                border-radius: 50% 50% 0 0;
            }
            @keyframes yr-wave-move {
                0% {
                    transform: translateX(0);
                }
                100% {
                    transform: translateX(-50%);
                }
            }
            .yr-preloader-inner {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                z-index: 2;
                position: relative;
                background: radial-gradient(circle, #ffffff 0%, #ffffff 50%, rgba(255,255,255,0.8) 65%, rgba(255,255,255,0) 80%);
                padding: 60px;
                border-radius: 50%;
            }
            .yr-preloader-gif {
                width: 120px;
                height: auto;
            }
            @media (max-width: 480px) {
                .yr-preloader-gif {
                    width: 100px;
                }
            }
        </style>
        <?php
    }
}

/**
 * Add preloader script
 */
if ( ! function_exists( 'yacht_rental_preloader_script' ) ) {
    add_action( 'wp_footer', 'yacht_rental_preloader_script', 999 );

    function yacht_rental_preloader_script() {
        ?>
        <script id="yr-preloader-script">
            (function() {
                var preloader = document.getElementById('yr-preloader');
                if (!preloader) return;

                function hidePreloader() {
                    preloader.classList.add('yr-preloader-hidden');
                    setTimeout(function() {
                        preloader.style.display = 'none';
                    }, 300);
                }

                // Hide after 500ms (half a second)
                setTimeout(hidePreloader, 500);
            })();
        </script>
        <?php
    }
}
