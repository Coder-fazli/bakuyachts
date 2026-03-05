<?php
/**
 * Custom Meta Boxes for About CPT
 *
 * All sections are managed from ONE single "About" post:
 * - Hero Section
 * - Partners Section
 * - Reviews Section
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0
 */

// Enqueue media uploader scripts for About CPT
function yr_about_enqueue_media_scripts( $hook ) {
    global $post;
    if ( $hook === 'post.php' || $hook === 'post-new.php' ) {
        if ( isset( $post->post_type ) && $post->post_type === 'about' ) {
            wp_enqueue_media();
        }
    }
}
add_action( 'admin_enqueue_scripts', 'yr_about_enqueue_media_scripts' );

// Add meta boxes for the About CPT
function yr_about_cpt_meta_boxes() {
    add_meta_box(
        'yr_about_hero_section',
        __( 'Hero Section', 'yacht-rental' ),
        'yr_about_hero_callback',
        'about',
        'normal',
        'high'
    );

    add_meta_box(
        'yr_about_founder_section',
        __( 'Founder Section', 'yacht-rental' ),
        'yr_about_founder_callback',
        'about',
        'normal',
        'default'
    );

    add_meta_box(
        'yr_about_reviews_section',
        __( 'Reviews Section (Voyager Stories)', 'yacht-rental' ),
        'yr_about_reviews_callback',
        'about',
        'normal',
        'default'
    );
}
add_action( 'add_meta_boxes', 'yr_about_cpt_meta_boxes' );

/**
 * Hero Section Callback
 */
function yr_about_hero_callback( $post ) {
    wp_nonce_field( 'yr_about_meta_box', 'yr_about_meta_box_nonce' );

    $subheading = get_post_meta( $post->ID, '_yr_hero_subheading', true );
    $content = get_post_meta( $post->ID, '_yr_hero_content', true );
    $stats_yachts = get_post_meta( $post->ID, '_yr_stats_yachts', true );
    $stats_voyages = get_post_meta( $post->ID, '_yr_stats_voyages', true );
    $stats_concierge = get_post_meta( $post->ID, '_yr_stats_concierge', true );
    // Stat labels
    $stats_yachts_label = get_post_meta( $post->ID, '_yr_stats_yachts_label', true );
    $stats_voyages_label = get_post_meta( $post->ID, '_yr_stats_voyages_label', true );
    $stats_concierge_label = get_post_meta( $post->ID, '_yr_stats_concierge_label', true );
    ?>
    <p class="description"><?php _e( '<strong>Title field above</strong> = Main heading. You can use HTML like: <code>Mastering the &lt;span class="text-gray-300 font-light italic"&gt;Art&lt;/span&gt; of Voyaging.</code>', 'yacht-rental' ); ?></p>
    <p class="description"><?php _e( '<strong>Featured Image</strong> (right sidebar) = Hero image', 'yacht-rental' ); ?></p>

    <table class="form-table">
        <tr>
            <th><label for="yr_hero_subheading"><?php _e( 'Subheading (above title)', 'yacht-rental' ); ?></label></th>
            <td><input type="text" id="yr_hero_subheading" name="yr_hero_subheading" value="<?php echo esc_attr( $subheading ); ?>" class="large-text" placeholder="e.g., Excellence at Sea" /></td>
        </tr>
        <tr>
            <th><label for="yr_hero_content"><?php _e( 'Description', 'yacht-rental' ); ?></label></th>
            <td><textarea id="yr_hero_content" name="yr_hero_content" class="large-text" rows="3" placeholder="We specialize in curated yachting experiences..."><?php echo esc_textarea( $content ); ?></textarea></td>
        </tr>
        <tr>
            <th colspan="2"><strong><?php _e( 'Statistics', 'yacht-rental' ); ?></strong></th>
        </tr>
        <tr>
            <th><label for="yr_stats_yachts"><?php _e( 'Stat 1 - Value', 'yacht-rental' ); ?></label></th>
            <td><input type="text" id="yr_stats_yachts" name="yr_stats_yachts" value="<?php echo esc_attr( $stats_yachts ); ?>" class="regular-text" placeholder="e.g., 45+" /></td>
        </tr>
        <tr>
            <th><label for="yr_stats_yachts_label"><?php _e( 'Stat 1 - Label', 'yacht-rental' ); ?></label></th>
            <td><input type="text" id="yr_stats_yachts_label" name="yr_stats_yachts_label" value="<?php echo esc_attr( $stats_yachts_label ); ?>" class="regular-text" placeholder="Luxury Yachts" /></td>
        </tr>
        <tr>
            <th><label for="yr_stats_voyages"><?php _e( 'Stat 2 - Value', 'yacht-rental' ); ?></label></th>
            <td><input type="text" id="yr_stats_voyages" name="yr_stats_voyages" value="<?php echo esc_attr( $stats_voyages ); ?>" class="regular-text" placeholder="e.g., 150+" /></td>
        </tr>
        <tr>
            <th><label for="yr_stats_voyages_label"><?php _e( 'Stat 2 - Label', 'yacht-rental' ); ?></label></th>
            <td><input type="text" id="yr_stats_voyages_label" name="yr_stats_voyages_label" value="<?php echo esc_attr( $stats_voyages_label ); ?>" class="regular-text" placeholder="Voyages Delivered" /></td>
        </tr>
        <tr>
            <th><label for="yr_stats_concierge"><?php _e( 'Stat 3 - Value', 'yacht-rental' ); ?></label></th>
            <td><input type="text" id="yr_stats_concierge" name="yr_stats_concierge" value="<?php echo esc_attr( $stats_concierge ); ?>" class="regular-text" placeholder="e.g., 24/7" /></td>
        </tr>
        <tr>
            <th><label for="yr_stats_concierge_label"><?php _e( 'Stat 3 - Label', 'yacht-rental' ); ?></label></th>
            <td><input type="text" id="yr_stats_concierge_label" name="yr_stats_concierge_label" value="<?php echo esc_attr( $stats_concierge_label ); ?>" class="regular-text" placeholder="VIP Concierge" /></td>
        </tr>
    </table>
    <?php
}

/**
 * Founder Section Callback
 */
function yr_about_founder_callback( $post ) {
    $image_id  = get_post_meta( $post->ID, '_yr_founder_image_id', true );
    $image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'large' ) : '';
    $subtitle  = get_post_meta( $post->ID, '_yr_founder_subtitle', true );
    $title     = get_post_meta( $post->ID, '_yr_founder_title', true );
    $text      = get_post_meta( $post->ID, '_yr_founder_text', true );
    $name      = get_post_meta( $post->ID, '_yr_founder_name', true );
    $role      = get_post_meta( $post->ID, '_yr_founder_role', true );
    ?>
    <p class="description"><?php _e( 'Displayed right after the hero section on the About page. Image on the left, content on the right.', 'yacht-rental' ); ?></p>
    <input type="hidden" id="yr-founder-image-id" name="yr_founder_image_id" value="<?php echo esc_attr( $image_id ); ?>">

    <table class="form-table">
        <tr>
            <th><label><?php _e( 'Founder Image', 'yacht-rental' ); ?></label></th>
            <td>
                <div id="yr-founder-image-preview" style="margin-bottom:10px;">
                    <?php if ( $image_url ) : ?>
                        <img src="<?php echo esc_url( $image_url ); ?>" style="max-height:250px; width:auto; display:block; border-radius:6px;">
                    <?php endif; ?>
                </div>
                <button type="button" id="yr-upload-founder-image" class="button"><?php _e( 'Upload / Change Image', 'yacht-rental' ); ?></button>
                <button type="button" id="yr-remove-founder-image" class="button" style="margin-left:8px;<?php echo $image_id ? '' : 'display:none;'; ?>"><?php _e( 'Remove', 'yacht-rental' ); ?></button>
                <p class="description"><?php _e( 'Recommended: tall/portrait image (e.g. 600×800px).', 'yacht-rental' ); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="yr_founder_subtitle"><?php _e( 'Subtitle (above title)', 'yacht-rental' ); ?></label></th>
            <td><input type="text" id="yr_founder_subtitle" name="yr_founder_subtitle" value="<?php echo esc_attr( $subtitle ); ?>" class="large-text" placeholder="e.g. About the Founder"></td>
        </tr>
        <tr>
            <th><label for="yr_founder_title"><?php _e( 'Title', 'yacht-rental' ); ?></label></th>
            <td><input type="text" id="yr_founder_title" name="yr_founder_title" value="<?php echo esc_attr( $title ); ?>" class="large-text" placeholder="e.g. Passion for the Sea"></td>
        </tr>
        <tr>
            <th><label for="yr_founder_text"><?php _e( 'Description', 'yacht-rental' ); ?></label></th>
            <td><textarea id="yr_founder_text" name="yr_founder_text" rows="6" class="large-text"><?php echo esc_textarea( $text ); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="yr_founder_name"><?php _e( 'Founder Name', 'yacht-rental' ); ?></label></th>
            <td><input type="text" id="yr_founder_name" name="yr_founder_name" value="<?php echo esc_attr( $name ); ?>" class="regular-text" placeholder="e.g. Anar Mammadov"></td>
        </tr>
        <tr>
            <th><label for="yr_founder_role"><?php _e( 'Role / Title', 'yacht-rental' ); ?></label></th>
            <td><input type="text" id="yr_founder_role" name="yr_founder_role" value="<?php echo esc_attr( $role ); ?>" class="regular-text" placeholder="e.g. Founder & CEO"></td>
        </tr>
    </table>

    <script>
    jQuery(document).ready(function($) {
        var founderFrame;

        $('#yr-upload-founder-image').on('click', function(e) {
            e.preventDefault();
            if (founderFrame) { founderFrame.open(); return; }
            founderFrame = wp.media({
                title: '<?php echo esc_js( __( 'Select Founder Image', 'yacht-rental' ) ); ?>',
                button: { text: '<?php echo esc_js( __( 'Use This Image', 'yacht-rental' ) ); ?>' },
                multiple: false,
                library: { type: 'image' }
            });
            founderFrame.on('select', function() {
                var attachment = founderFrame.state().get('selection').first().toJSON();
                $('#yr-founder-image-id').val(attachment.id);
                var url = attachment.sizes && attachment.sizes.large ? attachment.sizes.large.url : attachment.url;
                $('#yr-founder-image-preview').html('<img src="' + url + '" style="max-height:250px; width:auto; display:block; border-radius:6px;">');
                $('#yr-remove-founder-image').show();
            });
            founderFrame.open();
        });

        $('#yr-remove-founder-image').on('click', function() {
            $('#yr-founder-image-id').val('');
            $('#yr-founder-image-preview').html('');
            $(this).hide();
        });
    });
    </script>
    <?php
}

/**
 * Reviews Section Callback
 */
function yr_about_reviews_callback( $post ) {
    $reviews_title = get_post_meta( $post->ID, '_yr_reviews_title', true );
    $reviews = get_post_meta( $post->ID, '_yr_reviews', true );
    if ( ! is_array( $reviews ) ) {
        $reviews = array();
    }
    ?>
    <table class="form-table">
        <tr>
            <th><label for="yr_reviews_title"><?php _e( 'Section Title', 'yacht-rental' ); ?></label></th>
            <td><input type="text" id="yr_reviews_title" name="yr_reviews_title" value="<?php echo esc_attr( $reviews_title ); ?>" class="large-text" placeholder="Voyager Stories" /></td>
        </tr>
    </table>
    <p class="description"><?php _e( 'Add customer reviews/testimonials. They will be displayed 2 per slide.', 'yacht-rental' ); ?></p>

    <div id="yr-reviews-container">
        <?php
        if ( ! empty( $reviews ) ) :
            foreach ( $reviews as $index => $review ) :
        ?>
        <div class="yr-review-item" style="background:#f9f9f9; padding:15px; margin:10px 0; border:1px solid #ddd; border-radius:5px;">
            <p><strong><?php _e( 'Review', 'yacht-rental' ); ?> #<?php echo $index + 1; ?></strong>
            <a href="#" class="yr-remove-review" style="color:red; float:right;"><?php _e( 'Remove', 'yacht-rental' ); ?></a></p>
            <table class="form-table" style="margin:0;">
                <tr>
                    <th style="width:150px;"><label><?php _e( 'Reviewer Name', 'yacht-rental' ); ?></label></th>
                    <td><input type="text" name="yr_reviews[<?php echo $index; ?>][name]" value="<?php echo esc_attr( $review['name'] ?? '' ); ?>" class="regular-text" placeholder="Julian Pierce" /></td>
                </tr>
                <tr>
                    <th><label><?php _e( 'Subtitle', 'yacht-rental' ); ?></label></th>
                    <td><input type="text" name="yr_reviews[<?php echo $index; ?>][subtitle]" value="<?php echo esc_attr( $review['subtitle'] ?? '' ); ?>" class="regular-text" placeholder="Chartered 'The Seafarer'" /></td>
                </tr>
                <tr>
                    <th><label><?php _e( 'Review Text', 'yacht-rental' ); ?></label></th>
                    <td><textarea name="yr_reviews[<?php echo $index; ?>][text]" class="large-text" rows="2" placeholder="The most seamless charter we've ever experienced..."><?php echo esc_textarea( $review['text'] ?? '' ); ?></textarea></td>
                </tr>
                <tr>
                    <th><label><?php _e( 'Photo', 'yacht-rental' ); ?></label></th>
                    <td>
                        <div class="yr-photo-upload-wrap" style="display: flex; align-items: center; gap: 10px;">
                            <input type="text" name="yr_reviews[<?php echo $index; ?>][photo]" value="<?php echo esc_url( $review['photo'] ?? '' ); ?>" class="regular-text yr-photo-url" placeholder="<?php _e( 'Image URL', 'yacht-rental' ); ?>" />
                            <button type="button" class="button yr-upload-photo-btn"><?php _e( 'Upload Image', 'yacht-rental' ); ?></button>
                            <button type="button" class="button yr-remove-photo-btn" style="<?php echo empty( $review['photo'] ) ? 'display:none;' : ''; ?>"><?php _e( 'Remove', 'yacht-rental' ); ?></button>
                        </div>
                        <?php if ( ! empty( $review['photo'] ) ) : ?>
                        <div class="yr-photo-preview" style="margin-top: 10px;">
                            <img src="<?php echo esc_url( $review['photo'] ); ?>" style="max-width: 100px; height: auto; border-radius: 50%;" />
                        </div>
                        <?php else : ?>
                        <div class="yr-photo-preview" style="margin-top: 10px; display: none;">
                            <img src="" style="max-width: 100px; height: auto; border-radius: 50%;" />
                        </div>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </div>
        <?php
            endforeach;
        endif;
        ?>
    </div>

    <p><button type="button" id="yr-add-review" class="button button-secondary"><?php _e( '+ Add Review', 'yacht-rental' ); ?></button></p>

    <script>
    jQuery(document).ready(function($) {
        var reviewIndex = <?php echo count( $reviews ); ?>;

        $('#yr-add-review').on('click', function(e) {
            e.preventDefault();
            var template = `
            <div class="yr-review-item" style="background:#f9f9f9; padding:15px; margin:10px 0; border:1px solid #ddd; border-radius:5px;">
                <p><strong><?php _e( 'Review', 'yacht-rental' ); ?> #${reviewIndex + 1}</strong>
                <a href="#" class="yr-remove-review" style="color:red; float:right;"><?php _e( 'Remove', 'yacht-rental' ); ?></a></p>
                <table class="form-table" style="margin:0;">
                    <tr>
                        <th style="width:150px;"><label><?php _e( 'Reviewer Name', 'yacht-rental' ); ?></label></th>
                        <td><input type="text" name="yr_reviews[${reviewIndex}][name]" class="regular-text" placeholder="Julian Pierce" /></td>
                    </tr>
                    <tr>
                        <th><label><?php _e( 'Subtitle', 'yacht-rental' ); ?></label></th>
                        <td><input type="text" name="yr_reviews[${reviewIndex}][subtitle]" class="regular-text" placeholder="Chartered 'The Seafarer'" /></td>
                    </tr>
                    <tr>
                        <th><label><?php _e( 'Review Text', 'yacht-rental' ); ?></label></th>
                        <td><textarea name="yr_reviews[${reviewIndex}][text]" class="large-text" rows="2" placeholder="The most seamless charter we've ever experienced..."></textarea></td>
                    </tr>
                    <tr>
                        <th><label><?php _e( 'Photo', 'yacht-rental' ); ?></label></th>
                        <td>
                            <div class="yr-photo-upload-wrap" style="display: flex; align-items: center; gap: 10px;">
                                <input type="text" name="yr_reviews[${reviewIndex}][photo]" class="regular-text yr-photo-url" placeholder="<?php _e( 'Image URL', 'yacht-rental' ); ?>" />
                                <button type="button" class="button yr-upload-photo-btn"><?php _e( 'Upload Image', 'yacht-rental' ); ?></button>
                                <button type="button" class="button yr-remove-photo-btn" style="display:none;"><?php _e( 'Remove', 'yacht-rental' ); ?></button>
                            </div>
                            <div class="yr-photo-preview" style="margin-top: 10px; display: none;">
                                <img src="" style="max-width: 100px; height: auto; border-radius: 50%;" />
                            </div>
                        </td>
                    </tr>
                </table>
            </div>`;
            $('#yr-reviews-container').append(template);
            reviewIndex++;
        });

        $(document).on('click', '.yr-remove-review', function(e) {
            e.preventDefault();
            $(this).closest('.yr-review-item').remove();
        });

        // WordPress Media Uploader for review photos
        $(document).on('click', '.yr-upload-photo-btn', function(e) {
            e.preventDefault();
            var $button = $(this);
            var $wrap = $button.closest('.yr-photo-upload-wrap');
            var $input = $wrap.find('.yr-photo-url');
            var $removeBtn = $wrap.find('.yr-remove-photo-btn');
            var $preview = $wrap.closest('td').find('.yr-photo-preview');
            var $previewImg = $preview.find('img');

            var mediaUploader = wp.media({
                title: '<?php _e( 'Select Reviewer Photo', 'yacht-rental' ); ?>',
                button: {
                    text: '<?php _e( 'Use This Image', 'yacht-rental' ); ?>'
                },
                multiple: false,
                library: {
                    type: 'image'
                }
            });

            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                var imageUrl = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
                $input.val(attachment.url);
                $previewImg.attr('src', imageUrl);
                $preview.show();
                $removeBtn.show();
            });

            mediaUploader.open();
        });

        // Remove photo
        $(document).on('click', '.yr-remove-photo-btn', function(e) {
            e.preventDefault();
            var $button = $(this);
            var $wrap = $button.closest('.yr-photo-upload-wrap');
            var $input = $wrap.find('.yr-photo-url');
            var $preview = $wrap.closest('td').find('.yr-photo-preview');

            $input.val('');
            $preview.hide();
            $button.hide();
        });
    });
    </script>
    <?php
}

/**
 * Save meta data
 */
function yr_save_about_cpt_meta( $post_id ) {
    // Security checks
    if ( ! isset( $_POST['yr_about_meta_box_nonce'] ) ) {
        return;
    }
    if ( ! wp_verify_nonce( $_POST['yr_about_meta_box_nonce'], 'yr_about_meta_box' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    if ( 'about' !== get_post_type( $post_id ) ) {
        return;
    }

    // Hero fields
    if ( isset( $_POST['yr_hero_subheading'] ) ) {
        update_post_meta( $post_id, '_yr_hero_subheading', sanitize_text_field( $_POST['yr_hero_subheading'] ) );
    }
    if ( isset( $_POST['yr_hero_content'] ) ) {
        update_post_meta( $post_id, '_yr_hero_content', sanitize_textarea_field( $_POST['yr_hero_content'] ) );
    }
    if ( isset( $_POST['yr_stats_yachts'] ) ) {
        update_post_meta( $post_id, '_yr_stats_yachts', sanitize_text_field( $_POST['yr_stats_yachts'] ) );
    }
    if ( isset( $_POST['yr_stats_yachts_label'] ) ) {
        update_post_meta( $post_id, '_yr_stats_yachts_label', sanitize_text_field( $_POST['yr_stats_yachts_label'] ) );
    }
    if ( isset( $_POST['yr_stats_voyages'] ) ) {
        update_post_meta( $post_id, '_yr_stats_voyages', sanitize_text_field( $_POST['yr_stats_voyages'] ) );
    }
    if ( isset( $_POST['yr_stats_voyages_label'] ) ) {
        update_post_meta( $post_id, '_yr_stats_voyages_label', sanitize_text_field( $_POST['yr_stats_voyages_label'] ) );
    }
    if ( isset( $_POST['yr_stats_concierge'] ) ) {
        update_post_meta( $post_id, '_yr_stats_concierge', sanitize_text_field( $_POST['yr_stats_concierge'] ) );
    }
    if ( isset( $_POST['yr_stats_concierge_label'] ) ) {
        update_post_meta( $post_id, '_yr_stats_concierge_label', sanitize_text_field( $_POST['yr_stats_concierge_label'] ) );
    }

    // Founder fields
    update_post_meta( $post_id, '_yr_founder_image_id', intval( $_POST['yr_founder_image_id'] ?? 0 ) );
    update_post_meta( $post_id, '_yr_founder_subtitle', sanitize_text_field( $_POST['yr_founder_subtitle'] ?? '' ) );
    update_post_meta( $post_id, '_yr_founder_title', sanitize_text_field( $_POST['yr_founder_title'] ?? '' ) );
    update_post_meta( $post_id, '_yr_founder_text', wp_kses_post( $_POST['yr_founder_text'] ?? '' ) );
    update_post_meta( $post_id, '_yr_founder_name', sanitize_text_field( $_POST['yr_founder_name'] ?? '' ) );
    update_post_meta( $post_id, '_yr_founder_role', sanitize_text_field( $_POST['yr_founder_role'] ?? '' ) );

    // Reviews
    if ( isset( $_POST['yr_reviews_title'] ) ) {
        update_post_meta( $post_id, '_yr_reviews_title', sanitize_text_field( $_POST['yr_reviews_title'] ) );
    }
    if ( isset( $_POST['yr_reviews'] ) && is_array( $_POST['yr_reviews'] ) ) {
        $reviews = array();
        foreach ( $_POST['yr_reviews'] as $review ) {
            if ( ! empty( $review['name'] ) || ! empty( $review['text'] ) ) {
                $reviews[] = array(
                    'name' => sanitize_text_field( $review['name'] ?? '' ),
                    'subtitle' => sanitize_text_field( $review['subtitle'] ?? '' ),
                    'text' => sanitize_textarea_field( $review['text'] ?? '' ),
                    'photo' => esc_url_raw( $review['photo'] ?? '' ),
                );
            }
        }
        update_post_meta( $post_id, '_yr_reviews', $reviews );
    } else {
        update_post_meta( $post_id, '_yr_reviews', array() );
    }
}
add_action( 'save_post', 'yr_save_about_cpt_meta' );
