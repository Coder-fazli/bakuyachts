<?php
/**
 * Custom Post Type: Hero Sections
 *
 * Creates a custom post type for managing hero sections that can be displayed
 * on any page via shortcode [hero_section id="123"] or [hero_section]
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register Hero Section Custom Post Type
 */
if ( ! function_exists( 'yacht_rental_register_hero_section_cpt' ) ) {
    add_action( 'init', 'yacht_rental_register_hero_section_cpt' );

    function yacht_rental_register_hero_section_cpt() {
        $labels = array(
            'name'                  => _x( 'Hero Sections', 'Post Type General Name', 'yacht-rental' ),
            'singular_name'         => _x( 'Hero Section', 'Post Type Singular Name', 'yacht-rental' ),
            'menu_name'             => __( 'Hero Sections', 'yacht-rental' ),
            'name_admin_bar'        => __( 'Hero Section', 'yacht-rental' ),
            'archives'              => __( 'Hero Section Archives', 'yacht-rental' ),
            'attributes'            => __( 'Hero Section Attributes', 'yacht-rental' ),
            'parent_item_colon'     => __( 'Parent Hero Section:', 'yacht-rental' ),
            'all_items'             => __( 'All Hero Sections', 'yacht-rental' ),
            'add_new_item'          => __( 'Add New Hero Section', 'yacht-rental' ),
            'add_new'               => __( 'Add New', 'yacht-rental' ),
            'new_item'              => __( 'New Hero Section', 'yacht-rental' ),
            'edit_item'             => __( 'Edit Hero Section', 'yacht-rental' ),
            'update_item'           => __( 'Update Hero Section', 'yacht-rental' ),
            'view_item'             => __( 'View Hero Section', 'yacht-rental' ),
            'view_items'            => __( 'View Hero Sections', 'yacht-rental' ),
            'search_items'          => __( 'Search Hero Section', 'yacht-rental' ),
            'not_found'             => __( 'Not found', 'yacht-rental' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'yacht-rental' ),
            'featured_image'        => __( 'Background Image', 'yacht-rental' ),
            'set_featured_image'    => __( 'Set background image', 'yacht-rental' ),
            'remove_featured_image' => __( 'Remove background image', 'yacht-rental' ),
            'use_featured_image'    => __( 'Use as background image', 'yacht-rental' ),
            'insert_into_item'      => __( 'Insert into hero section', 'yacht-rental' ),
            'uploaded_to_this_item' => __( 'Uploaded to this hero section', 'yacht-rental' ),
            'items_list'            => __( 'Hero sections list', 'yacht-rental' ),
            'items_list_navigation' => __( 'Hero sections list navigation', 'yacht-rental' ),
            'filter_items_list'     => __( 'Filter hero sections list', 'yacht-rental' ),
        );

        $args = array(
            'label'                 => __( 'Hero Section', 'yacht-rental' ),
            'description'           => __( 'Hero sections for pages', 'yacht-rental' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'thumbnail' ),
            'hierarchical'          => false,
            'public'                => false,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 25,
            'menu_icon'             => 'dashicons-cover-image',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'has_archive'           => false,
            'exclude_from_search'   => true,
            'publicly_queryable'    => false,
            'capability_type'       => 'post',
            'show_in_rest'          => true,
        );

        register_post_type( 'hero_section', $args );
    }
}

/**
 * Add Meta Boxes for Hero Section
 */
if ( ! function_exists( 'yacht_rental_hero_section_meta_boxes' ) ) {
    add_action( 'add_meta_boxes', 'yacht_rental_hero_section_meta_boxes' );

    function yacht_rental_hero_section_meta_boxes() {
        add_meta_box(
            'hero_section_settings',
            __( 'Hero Section Settings', 'yacht-rental' ),
            'yacht_rental_hero_section_settings_callback',
            'hero_section',
            'normal',
            'high'
        );

        add_meta_box(
            'hero_section_shortcode',
            __( 'Shortcode', 'yacht-rental' ),
            'yacht_rental_hero_section_shortcode_callback',
            'hero_section',
            'side',
            'high'
        );
    }
}

/**
 * Shortcode Meta Box Callback
 */
if ( ! function_exists( 'yacht_rental_hero_section_shortcode_callback' ) ) {
    function yacht_rental_hero_section_shortcode_callback( $post ) {
        ?>
        <p><?php _e( 'Use this shortcode to display this hero section on any page:', 'yacht-rental' ); ?></p>
        <code style="display: block; padding: 10px; background: #f0f0f0; margin: 10px 0; word-break: break-all;">[hero_section id="<?php echo $post->ID; ?>"]</code>
        <p><small><?php _e( 'Or use [hero_section] without ID to show the most recent hero section.', 'yacht-rental' ); ?></small></p>
        <?php
    }
}

/**
 * Hero Section Settings Meta Box Callback
 */
if ( ! function_exists( 'yacht_rental_hero_section_settings_callback' ) ) {
    function yacht_rental_hero_section_settings_callback( $post ) {
        wp_nonce_field( 'hero_section_save_meta', 'hero_section_meta_nonce' );

        // Get saved values
        $hero_title = get_post_meta( $post->ID, '_hero_title', true );
        $hero_subtitle = get_post_meta( $post->ID, '_hero_subtitle', true );

        // Button 1
        $button1_text = get_post_meta( $post->ID, '_hero_button1_text', true );
        $button1_url = get_post_meta( $post->ID, '_hero_button1_url', true );
        $button1_style = get_post_meta( $post->ID, '_hero_button1_style', true );

        // Button 2
        $button2_text = get_post_meta( $post->ID, '_hero_button2_text', true );
        $button2_url = get_post_meta( $post->ID, '_hero_button2_url', true );
        $button2_style = get_post_meta( $post->ID, '_hero_button2_style', true );

        // Overlay settings
        $overlay_color = get_post_meta( $post->ID, '_hero_overlay_color', true );
        $overlay_opacity = get_post_meta( $post->ID, '_hero_overlay_opacity', true );

        // Height settings
        $hero_height = get_post_meta( $post->ID, '_hero_height', true );

        // Text alignment
        $text_align = get_post_meta( $post->ID, '_hero_text_align', true );

        // Defaults
        if ( empty( $overlay_color ) ) $overlay_color = '#000000';
        if ( empty( $overlay_opacity ) ) $overlay_opacity = '0.5';
        if ( empty( $hero_height ) ) $hero_height = '100';
        if ( empty( $text_align ) ) $text_align = 'left';
        if ( empty( $button1_style ) ) $button1_style = 'primary';
        if ( empty( $button2_style ) ) $button2_style = 'secondary';
        ?>

        <style>
            .hero-meta-row {
                margin-bottom: 20px;
                padding-bottom: 20px;
                border-bottom: 1px solid #eee;
            }
            .hero-meta-row:last-child {
                border-bottom: none;
            }
            .hero-meta-row label {
                display: block;
                font-weight: 600;
                margin-bottom: 5px;
            }
            .hero-meta-row input[type="text"],
            .hero-meta-row input[type="url"],
            .hero-meta-row input[type="number"],
            .hero-meta-row textarea,
            .hero-meta-row select {
                width: 100%;
                max-width: 500px;
            }
            .hero-meta-row textarea {
                height: 80px;
            }
            .hero-meta-row .description {
                color: #666;
                font-style: italic;
                margin-top: 5px;
            }
            .hero-section-group {
                background: #f9f9f9;
                padding: 15px;
                margin-bottom: 20px;
                border-radius: 5px;
            }
            .hero-section-group h4 {
                margin-top: 0;
                margin-bottom: 15px;
                padding-bottom: 10px;
                border-bottom: 1px solid #ddd;
            }
            .hero-buttons-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 20px;
            }
            @media (max-width: 782px) {
                .hero-buttons-grid {
                    grid-template-columns: 1fr;
                }
            }
        </style>

        <div class="hero-section-group">
            <h4><?php _e( 'Content', 'yacht-rental' ); ?></h4>

            <div class="hero-meta-row">
                <label for="hero_title"><?php _e( 'Hero Title', 'yacht-rental' ); ?></label>
                <input type="text" id="hero_title" name="hero_title" value="<?php echo esc_attr( $hero_title ); ?>" placeholder="<?php _e( 'Enter hero title...', 'yacht-rental' ); ?>">
                <p class="description"><?php _e( 'The main heading displayed in the hero section.', 'yacht-rental' ); ?></p>
            </div>

            <div class="hero-meta-row">
                <label for="hero_subtitle"><?php _e( 'Subtitle / Description', 'yacht-rental' ); ?></label>
                <textarea id="hero_subtitle" name="hero_subtitle" placeholder="<?php _e( 'Enter subtitle or description...', 'yacht-rental' ); ?>"><?php echo esc_textarea( $hero_subtitle ); ?></textarea>
                <p class="description"><?php _e( 'Optional subtitle or description text below the title.', 'yacht-rental' ); ?></p>
            </div>
        </div>

        <div class="hero-section-group">
            <h4><?php _e( 'Buttons', 'yacht-rental' ); ?></h4>

            <div class="hero-buttons-grid">
                <div class="hero-button-col">
                    <h5><?php _e( 'Button 1 (Primary)', 'yacht-rental' ); ?></h5>

                    <div class="hero-meta-row">
                        <label for="hero_button1_text"><?php _e( 'Button Text', 'yacht-rental' ); ?></label>
                        <input type="text" id="hero_button1_text" name="hero_button1_text" value="<?php echo esc_attr( $button1_text ); ?>" placeholder="<?php _e( 'e.g., Rent a Yacht', 'yacht-rental' ); ?>">
                    </div>

                    <div class="hero-meta-row">
                        <label for="hero_button1_url"><?php _e( 'Button URL', 'yacht-rental' ); ?></label>
                        <input type="url" id="hero_button1_url" name="hero_button1_url" value="<?php echo esc_url( $button1_url ); ?>" placeholder="<?php _e( 'https://', 'yacht-rental' ); ?>">
                    </div>

                    <div class="hero-meta-row">
                        <label for="hero_button1_style"><?php _e( 'Button Style', 'yacht-rental' ); ?></label>
                        <select id="hero_button1_style" name="hero_button1_style">
                            <option value="primary" <?php selected( $button1_style, 'primary' ); ?>><?php _e( 'Primary (Filled)', 'yacht-rental' ); ?></option>
                            <option value="secondary" <?php selected( $button1_style, 'secondary' ); ?>><?php _e( 'Secondary (Outline)', 'yacht-rental' ); ?></option>
                        </select>
                    </div>
                </div>

                <div class="hero-button-col">
                    <h5><?php _e( 'Button 2 (Secondary)', 'yacht-rental' ); ?></h5>

                    <div class="hero-meta-row">
                        <label for="hero_button2_text"><?php _e( 'Button Text', 'yacht-rental' ); ?></label>
                        <input type="text" id="hero_button2_text" name="hero_button2_text" value="<?php echo esc_attr( $button2_text ); ?>" placeholder="<?php _e( 'e.g., View Packages', 'yacht-rental' ); ?>">
                    </div>

                    <div class="hero-meta-row">
                        <label for="hero_button2_url"><?php _e( 'Button URL', 'yacht-rental' ); ?></label>
                        <input type="url" id="hero_button2_url" name="hero_button2_url" value="<?php echo esc_url( $button2_url ); ?>" placeholder="<?php _e( 'https://', 'yacht-rental' ); ?>">
                    </div>

                    <div class="hero-meta-row">
                        <label for="hero_button2_style"><?php _e( 'Button Style', 'yacht-rental' ); ?></label>
                        <select id="hero_button2_style" name="hero_button2_style">
                            <option value="primary" <?php selected( $button2_style, 'primary' ); ?>><?php _e( 'Primary (Filled)', 'yacht-rental' ); ?></option>
                            <option value="secondary" <?php selected( $button2_style, 'secondary' ); ?>><?php _e( 'Secondary (Outline)', 'yacht-rental' ); ?></option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="hero-section-group">
            <h4><?php _e( 'Appearance', 'yacht-rental' ); ?></h4>

            <div class="hero-meta-row">
                <label for="hero_height"><?php _e( 'Hero Height (vh)', 'yacht-rental' ); ?></label>
                <input type="number" id="hero_height" name="hero_height" value="<?php echo esc_attr( $hero_height ); ?>" min="30" max="100" step="5" style="width: 100px;">
                <span>vh</span>
                <p class="description"><?php _e( 'Height of the hero section. 100vh = full viewport height.', 'yacht-rental' ); ?></p>
            </div>

            <div class="hero-meta-row">
                <label for="hero_text_align"><?php _e( 'Text Alignment', 'yacht-rental' ); ?></label>
                <select id="hero_text_align" name="hero_text_align" style="width: 150px;">
                    <option value="left" <?php selected( $text_align, 'left' ); ?>><?php _e( 'Left', 'yacht-rental' ); ?></option>
                    <option value="center" <?php selected( $text_align, 'center' ); ?>><?php _e( 'Center', 'yacht-rental' ); ?></option>
                    <option value="right" <?php selected( $text_align, 'right' ); ?>><?php _e( 'Right', 'yacht-rental' ); ?></option>
                </select>
            </div>

            <div class="hero-meta-row">
                <label for="hero_overlay_color"><?php _e( 'Overlay Color', 'yacht-rental' ); ?></label>
                <input type="color" id="hero_overlay_color" name="hero_overlay_color" value="<?php echo esc_attr( $overlay_color ); ?>" style="width: 60px; height: 35px; padding: 0; border: 1px solid #ccc;">
                <p class="description"><?php _e( 'Color of the overlay on top of the background image.', 'yacht-rental' ); ?></p>
            </div>

            <div class="hero-meta-row">
                <label for="hero_overlay_opacity"><?php _e( 'Overlay Opacity', 'yacht-rental' ); ?></label>
                <input type="range" id="hero_overlay_opacity" name="hero_overlay_opacity" value="<?php echo esc_attr( $overlay_opacity ); ?>" min="0" max="1" step="0.1" style="width: 200px;">
                <span id="opacity_value"><?php echo esc_html( $overlay_opacity ); ?></span>
                <p class="description"><?php _e( '0 = transparent, 1 = fully opaque.', 'yacht-rental' ); ?></p>
            </div>
        </div>

        <p><strong><?php _e( 'Note:', 'yacht-rental' ); ?></strong> <?php _e( 'Set the background image using the "Featured Image" option in the right sidebar.', 'yacht-rental' ); ?></p>

        <script>
            jQuery(document).ready(function($) {
                $('#hero_overlay_opacity').on('input', function() {
                    $('#opacity_value').text($(this).val());
                });
            });
        </script>
        <?php
    }
}

/**
 * Save Hero Section Meta Data
 */
if ( ! function_exists( 'yacht_rental_save_hero_section_meta' ) ) {
    add_action( 'save_post_hero_section', 'yacht_rental_save_hero_section_meta' );

    function yacht_rental_save_hero_section_meta( $post_id ) {
        // Check nonce
        if ( ! isset( $_POST['hero_section_meta_nonce'] ) || ! wp_verify_nonce( $_POST['hero_section_meta_nonce'], 'hero_section_save_meta' ) ) {
            return;
        }

        // Check autosave
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        // Check permissions
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        // Save fields
        $fields = array(
            'hero_title'           => 'sanitize_text_field',
            'hero_subtitle'        => 'sanitize_textarea_field',
            'hero_button1_text'    => 'sanitize_text_field',
            'hero_button1_url'     => 'esc_url_raw',
            'hero_button1_style'   => 'sanitize_text_field',
            'hero_button2_text'    => 'sanitize_text_field',
            'hero_button2_url'     => 'esc_url_raw',
            'hero_button2_style'   => 'sanitize_text_field',
            'hero_overlay_color'   => 'sanitize_hex_color',
            'hero_overlay_opacity' => 'sanitize_text_field',
            'hero_height'          => 'absint',
            'hero_text_align'      => 'sanitize_text_field',
        );

        foreach ( $fields as $field => $sanitize_callback ) {
            if ( isset( $_POST[ $field ] ) ) {
                $value = call_user_func( $sanitize_callback, $_POST[ $field ] );
                update_post_meta( $post_id, '_' . $field, $value );
            }
        }
    }
}

/**
 * Hero Section Shortcode
 * Usage: [hero_section id="123"] or [hero_section]
 */
if ( ! function_exists( 'yacht_rental_hero_section_shortcode' ) ) {
    add_shortcode( 'hero_section', 'yacht_rental_hero_section_shortcode' );

    function yacht_rental_hero_section_shortcode( $atts ) {
        $atts = shortcode_atts( array(
            'id' => '',
        ), $atts, 'hero_section' );

        // Get hero section post
        if ( ! empty( $atts['id'] ) ) {
            $hero_post = get_post( intval( $atts['id'] ) );
        } else {
            // Get the most recent hero section
            $hero_posts = get_posts( array(
                'post_type'      => 'hero_section',
                'posts_per_page' => 1,
                'post_status'    => 'publish',
            ) );
            $hero_post = ! empty( $hero_posts ) ? $hero_posts[0] : null;
        }

        if ( ! $hero_post || $hero_post->post_type !== 'hero_section' ) {
            return '';
        }

        $post_id = $hero_post->ID;

        // Get meta values
        $hero_title = get_post_meta( $post_id, '_hero_title', true );
        $hero_subtitle = get_post_meta( $post_id, '_hero_subtitle', true );

        $button1_text = get_post_meta( $post_id, '_hero_button1_text', true );
        $button1_url = get_post_meta( $post_id, '_hero_button1_url', true );
        $button1_style = get_post_meta( $post_id, '_hero_button1_style', true );

        $button2_text = get_post_meta( $post_id, '_hero_button2_text', true );
        $button2_url = get_post_meta( $post_id, '_hero_button2_url', true );
        $button2_style = get_post_meta( $post_id, '_hero_button2_style', true );

        $overlay_color = get_post_meta( $post_id, '_hero_overlay_color', true );
        $overlay_opacity = get_post_meta( $post_id, '_hero_overlay_opacity', true );
        $hero_height = get_post_meta( $post_id, '_hero_height', true );
        $text_align = get_post_meta( $post_id, '_hero_text_align', true );

        // Defaults
        if ( empty( $overlay_color ) ) $overlay_color = '#000000';
        if ( empty( $overlay_opacity ) ) $overlay_opacity = '0.5';
        if ( empty( $hero_height ) ) $hero_height = '100';
        if ( empty( $text_align ) ) $text_align = 'left';
        if ( empty( $button1_style ) ) $button1_style = 'primary';
        if ( empty( $button2_style ) ) $button2_style = 'secondary';

        // Get background image
        $bg_image = get_the_post_thumbnail_url( $post_id, 'full' );
        if ( empty( $bg_image ) ) {
            $bg_image = '';
        }

        // Convert hex to rgba
        $rgb = yacht_rental_hex_to_rgb( $overlay_color );
        $overlay_rgba = "rgba({$rgb['r']}, {$rgb['g']}, {$rgb['b']}, {$overlay_opacity})";

        // Calculate container alignment
        $container_style = '';
        if ( $text_align === 'center' ) {
            $container_style = 'margin-left: auto; margin-right: auto; text-align: center;';
        } elseif ( $text_align === 'right' ) {
            $container_style = 'margin-left: auto; margin-right: 102px; text-align: right;';
        }

        // Build output
        ob_start();
        ?>
        <section class="yacht-hero-section" style="min-height: <?php echo esc_attr( $hero_height ); ?>vh; <?php if ( $bg_image ) : ?>--hero-bg: url('<?php echo esc_url( $bg_image ); ?>'); --hero-overlay: <?php echo esc_attr( $overlay_rgba ); ?>;<?php endif; ?>">
            <div class="yacht-hero-container" style="<?php echo esc_attr( $container_style ); ?>">
                <?php if ( ! empty( $hero_title ) || ! empty( $hero_subtitle ) ) : ?>
                <div class="yacht-hero-info">
                    <?php if ( ! empty( $hero_title ) ) : ?>
                    <h1 class="yacht-hero-title"><?php echo esc_html( $hero_title ); ?></h1>
                    <?php endif; ?>

                    <?php if ( ! empty( $hero_subtitle ) ) : ?>
                    <p class="yacht-hero-subtitle"><?php echo esc_html( $hero_subtitle ); ?></p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <?php if ( ! empty( $button1_text ) || ! empty( $button2_text ) ) : ?>
                <div class="yacht-hero-buttons" style="<?php echo $text_align === 'center' ? 'justify-content: center;' : ( $text_align === 'right' ? 'justify-content: flex-end;' : '' ); ?>">
                    <?php if ( ! empty( $button1_text ) ) : ?>
                    <a href="<?php echo esc_url( $button1_url ); ?>" class="yacht-hero-btn yacht-hero-btn-<?php echo esc_attr( $button1_style ); ?>">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                        <?php echo esc_html( $button1_text ); ?>
                    </a>
                    <?php endif; ?>

                    <?php if ( ! empty( $button2_text ) ) : ?>
                    <a href="<?php echo esc_url( $button2_url ); ?>" class="yacht-hero-btn yacht-hero-btn-<?php echo esc_attr( $button2_style ); ?>">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                        <?php echo esc_html( $button2_text ); ?>
                    </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </section>
        <?php
        return ob_get_clean();
    }
}

/**
 * Helper function to convert hex color to RGB
 */
if ( ! function_exists( 'yacht_rental_hex_to_rgb' ) ) {
    function yacht_rental_hex_to_rgb( $hex ) {
        $hex = str_replace( '#', '', $hex );

        if ( strlen( $hex ) == 3 ) {
            $r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
            $g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
            $b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
        } else {
            $r = hexdec( substr( $hex, 0, 2 ) );
            $g = hexdec( substr( $hex, 2, 2 ) );
            $b = hexdec( substr( $hex, 4, 2 ) );
        }

        return array( 'r' => $r, 'g' => $g, 'b' => $b );
    }
}

/**
 * Enqueue Hero Section Styles
 */
if ( ! function_exists( 'yacht_rental_hero_section_styles' ) ) {
    add_action( 'wp_enqueue_scripts', 'yacht_rental_hero_section_styles' );

    function yacht_rental_hero_section_styles() {
        wp_enqueue_style(
            'yacht-rental-hero-section',
            YACHT_RENTAL_THEME_URL . 'css/hero-section.css',
            array(),
            filemtime( YACHT_RENTAL_THEME_DIR . 'css/hero-section.css' )
        );
    }
}

/**
 * Add Hero Section column to admin list
 */
if ( ! function_exists( 'yacht_rental_hero_section_columns' ) ) {
    add_filter( 'manage_hero_section_posts_columns', 'yacht_rental_hero_section_columns' );

    function yacht_rental_hero_section_columns( $columns ) {
        $new_columns = array();
        foreach ( $columns as $key => $value ) {
            $new_columns[ $key ] = $value;
            if ( $key === 'title' ) {
                $new_columns['shortcode'] = __( 'Shortcode', 'yacht-rental' );
                $new_columns['hero_image'] = __( 'Background', 'yacht-rental' );
            }
        }
        return $new_columns;
    }
}

/**
 * Display Hero Section column content
 */
if ( ! function_exists( 'yacht_rental_hero_section_column_content' ) ) {
    add_action( 'manage_hero_section_posts_custom_column', 'yacht_rental_hero_section_column_content', 10, 2 );

    function yacht_rental_hero_section_column_content( $column, $post_id ) {
        switch ( $column ) {
            case 'shortcode':
                echo '<code>[hero_section id="' . $post_id . '"]</code>';
                break;
            case 'hero_image':
                if ( has_post_thumbnail( $post_id ) ) {
                    echo get_the_post_thumbnail( $post_id, array( 80, 50 ), array( 'style' => 'border-radius: 4px;' ) );
                } else {
                    echo '<span style="color: #999;">' . __( 'No image', 'yacht-rental' ) . '</span>';
                }
                break;
        }
    }
}
