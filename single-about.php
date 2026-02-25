<?php
/**
 * Single About Page Template
 *
 * Displays the About page content using the [yacht_about] shortcode
 * Works with Polylang - automatically shows content for current language
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0
 */

get_header();

// Ensure GTM noscript is output if wp_body_open wasn't called
if ( ! did_action( 'wp_body_open' ) ) : ?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PH2FSDL2"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php endif;

// Get current language for Polylang
$current_lang = '';
if ( function_exists( 'pll_current_language' ) ) {
    $current_lang = pll_current_language();
}

// Query the About post for current language
$query_args = array(
    'post_type'      => 'about',
    'posts_per_page' => 1,
    'post_status'    => 'publish',
);

if ( $current_lang ) {
    $query_args['lang'] = $current_lang;
}

$about_query = new WP_Query( $query_args );
?>

<style>
/* Remove theme default content wrapper padding for about page */
body.single-about .content_wrap,
body.single-about .page_content_wrap {
    padding-top: 0 !important;
    padding-bottom: 0 !important;
}
body.single-about .content {
    padding: 0 !important;
    margin: 0 !important;
    max-width: 100% !important;
    width: 100% !important;
}
body.single-about .page_content_wrap {
    margin-top: 0 !important;
}
/* Hide default title section on about page */
body.single-about .sc_layouts_title,
body.single-about .top_panel_title {
    display: none !important;
}
/* Reduce breadcrumb section spacing */
body.single-about .breadcrumbs_wrap,
body.single-about .sc_layouts_title_breadcrumbs {
    padding-top: 10px !important;
    padding-bottom: 10px !important;
    margin-bottom: 0 !important;
}
/* Fix breadcrumb styles to match other pages (like Gallery) */
body.single-about .breadcrumbs,
body.single-about .breadcrumbs a,
body.single-about .breadcrumbs span,
body.single-about .breadcrumbs_item,
body.single-about .sc_layouts_title_breadcrumbs,
body.single-about .sc_layouts_title_breadcrumbs a,
body.single-about .sc_layouts_title_breadcrumbs span {
    font-family: var(--theme-font-h5_font-family, 'alga', serif) !important;
    font-size: 14px !important;
    font-weight: var(--theme-font-h5_font-weight, 500) !important;
    line-height: 1.5 !important;
    letter-spacing: var(--theme-font-h5_letter-spacing, 0px) !important;
    text-transform: var(--theme-font-h5_text-transform, none) !important;
}
body.single-about .breadcrumbs,
body.single-about .breadcrumbs span,
body.single-about .sc_layouts_title_breadcrumbs span {
    color: #5E6171 !important;
}
body.single-about .breadcrumbs a,
body.single-about .sc_layouts_title_breadcrumbs a {
    color: #BC1833 !important;
}
body.single-about .breadcrumbs a:hover,
body.single-about .sc_layouts_title_breadcrumbs a:hover {
    color: #A2142C !important;
}
</style>

<div class="page_content_wrap">
    <div class="content_wrap">
        <div class="content">
            <?php
            if ( $about_query->have_posts() ) {
                // Output the about shortcode content
                echo do_shortcode( '[yacht_about]' );
            } else {
                // No about post found for this language
                ?>
                <div style="padding: 100px 20px; text-align: center; max-width: 600px; margin: 0 auto;">
                    <h1 style="font-size: 32px; color: #333; margin-bottom: 20px;">
                        <?php _e( 'About Page', 'yacht-rental' ); ?>
                    </h1>
                    <p style="color: #666; font-size: 16px; line-height: 1.6;">
                        <?php
                        if ( $current_lang ) {
                            printf(
                                __( 'About content for language "%s" is not configured yet. Please create an About post for this language.', 'yacht-rental' ),
                                strtoupper( $current_lang )
                            );
                        } else {
                            _e( 'About content not configured. Go to About → Add New in WordPress admin.', 'yacht-rental' );
                        }
                        ?>
                    </p>
                </div>
                <?php
            }

            wp_reset_postdata();
            ?>
        </div>
    </div>
</div>

<?php
get_footer();
