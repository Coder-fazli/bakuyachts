<?php
/**
 * The Header: Logo and main menu
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js<?php
	// Class scheme_xxx need in the <html> as context for the <body>!
	echo ' scheme_' . esc_attr( yacht_rental_get_theme_option( 'color_scheme' ) );
?>">

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
	do_action( 'yacht_rental_action_before_body' );
	?>

	<div class="<?php echo esc_attr( apply_filters( 'yacht_rental_filter_body_wrap_class', 'body_wrap' ) ); ?>" <?php do_action('yacht_rental_action_body_wrap_attributes'); ?>>

		<?php do_action( 'yacht_rental_action_before_page_wrap' ); ?>

		<div class="<?php echo esc_attr( apply_filters( 'yacht_rental_filter_page_wrap_class', 'page_wrap' ) ); ?>" <?php do_action('yacht_rental_action_page_wrap_attributes'); ?>>

			<?php do_action( 'yacht_rental_action_page_wrap_start' ); ?>

			<?php
			$yacht_rental_full_post_loading = ( yacht_rental_is_singular( 'post' ) || yacht_rental_is_singular( 'attachment' ) ) && yacht_rental_get_value_gp( 'action' ) == 'full_post_loading';
			$yacht_rental_prev_post_loading = ( yacht_rental_is_singular( 'post' ) || yacht_rental_is_singular( 'attachment' ) ) && yacht_rental_get_value_gp( 'action' ) == 'prev_post_loading';

			// Don't display the header elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ! $yacht_rental_full_post_loading && ! $yacht_rental_prev_post_loading ) {

				// Short links to fast access to the content, sidebar and footer from the keyboard
				?>
				<a class="yacht_rental_skip_link skip_to_content_link" href="#content_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'yacht_rental_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to content", 'yacht-rental' ); ?></a>
				<?php if ( yacht_rental_sidebar_present() ) { ?>
				<a class="yacht_rental_skip_link skip_to_sidebar_link" href="#sidebar_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'yacht_rental_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to sidebar", 'yacht-rental' ); ?></a>
				<?php } ?>
				<a class="yacht_rental_skip_link skip_to_footer_link" href="#footer_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'yacht_rental_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to footer", 'yacht-rental' ); ?></a>

				<?php
				do_action( 'yacht_rental_action_before_header' );

				// Header
				$yacht_rental_header_type = yacht_rental_get_theme_option( 'header_type' );
				if ( 'custom' == $yacht_rental_header_type && ! yacht_rental_is_layouts_available() ) {
					$yacht_rental_header_type = 'default';
				}
				get_template_part( apply_filters( 'yacht_rental_filter_get_template_part', "templates/header-" . sanitize_file_name( $yacht_rental_header_type ) ) );

				// Side menu
				if ( in_array( yacht_rental_get_theme_option( 'menu_side', 'none' ), array( 'left', 'right' ) ) ) {
					get_template_part( apply_filters( 'yacht_rental_filter_get_template_part', 'templates/header-navi-side' ) );
				}

				// Mobile menu
				if ( apply_filters( 'yacht_rental_filter_use_navi_mobile', true ) ) {
					get_template_part( apply_filters( 'yacht_rental_filter_get_template_part', 'templates/header-navi-mobile' ) );
				}

				do_action( 'yacht_rental_action_after_header' );

			}
			?>

			<?php do_action( 'yacht_rental_action_before_page_content_wrap' ); ?>

			<div class="page_content_wrap<?php
				if ( yacht_rental_is_off( yacht_rental_get_theme_option( 'remove_margins' ) ) ) {
					if ( empty( $yacht_rental_header_type ) ) {
						$yacht_rental_header_type = yacht_rental_get_theme_option( 'header_type' );
					}
					if ( 'custom' == $yacht_rental_header_type && yacht_rental_is_layouts_available() ) {
						$yacht_rental_header_id = yacht_rental_get_custom_header_id();
						if ( $yacht_rental_header_id > 0 ) {
							$yacht_rental_header_meta = yacht_rental_get_custom_layout_meta( $yacht_rental_header_id );
							if ( ! empty( $yacht_rental_header_meta['margin'] ) ) {
								?> page_content_wrap_custom_header_margin<?php
							}
						}
					}
					$yacht_rental_footer_type = yacht_rental_get_theme_option( 'footer_type' );
					if ( 'custom' == $yacht_rental_footer_type && yacht_rental_is_layouts_available() ) {
						$yacht_rental_footer_id = yacht_rental_get_custom_footer_id();
						if ( $yacht_rental_footer_id ) {
							$yacht_rental_footer_meta = yacht_rental_get_custom_layout_meta( $yacht_rental_footer_id );
							if ( ! empty( $yacht_rental_footer_meta['margin'] ) ) {
								?> page_content_wrap_custom_footer_margin<?php
							}
						}
					}
				}
				do_action( 'yacht_rental_action_page_content_wrap_class', $yacht_rental_prev_post_loading );
				?>"<?php
				if ( apply_filters( 'yacht_rental_filter_is_prev_post_loading', $yacht_rental_prev_post_loading ) ) {
					?> data-single-style="<?php echo esc_attr( yacht_rental_get_theme_option( 'single_style' ) ); ?>"<?php
				}
				do_action( 'yacht_rental_action_page_content_wrap_data', $yacht_rental_prev_post_loading );
			?>>
				<?php
				do_action( 'yacht_rental_action_page_content_wrap', $yacht_rental_full_post_loading || $yacht_rental_prev_post_loading );

				// Single posts banner
				if ( apply_filters( 'yacht_rental_filter_single_post_header', yacht_rental_is_singular( 'post' ) || yacht_rental_is_singular( 'attachment' ) ) ) {
					if ( $yacht_rental_prev_post_loading ) {
						if ( yacht_rental_get_theme_option( 'posts_navigation_scroll_which_block', 'article' ) != 'article' ) {
							do_action( 'yacht_rental_action_between_posts' );
						}
					}
					// Single post thumbnail and title
					$yacht_rental_path = apply_filters( 'yacht_rental_filter_get_template_part', 'templates/single-styles/' . yacht_rental_get_theme_option( 'single_style' ) );
					if ( yacht_rental_get_file_dir( $yacht_rental_path . '.php' ) != '' ) {
						get_template_part( $yacht_rental_path );
					}
				}

				// Widgets area above page
				$yacht_rental_body_style   = yacht_rental_get_theme_option( 'body_style' );
				$yacht_rental_widgets_name = yacht_rental_get_theme_option( 'widgets_above_page', 'hide' );
				$yacht_rental_show_widgets = ! yacht_rental_is_off( $yacht_rental_widgets_name ) && is_active_sidebar( $yacht_rental_widgets_name );
				if ( $yacht_rental_show_widgets ) {
					if ( 'fullscreen' != $yacht_rental_body_style ) {
						?>
						<div class="content_wrap">
							<?php
					}
					yacht_rental_create_widgets_area( 'widgets_above_page' );
					if ( 'fullscreen' != $yacht_rental_body_style ) {
						?>
						</div>
						<?php
					}
				}

				// Content area
				do_action( 'yacht_rental_action_before_content_wrap' );
				?>
				<div class="content_wrap<?php echo 'fullscreen' == $yacht_rental_body_style ? '_fullscreen' : ''; ?>">

					<?php do_action( 'yacht_rental_action_content_wrap_start' ); ?>

					<div class="content">
						<?php
						do_action( 'yacht_rental_action_page_content_start' );

						// Skip link anchor to fast access to the content from keyboard
						?>
						<a id="content_skip_link_anchor" class="yacht_rental_skip_link_anchor" href="#"></a>
						<?php
						// Single posts banner between prev/next posts
						if ( ( yacht_rental_is_singular( 'post' ) || yacht_rental_is_singular( 'attachment' ) )
							&& $yacht_rental_prev_post_loading 
							&& yacht_rental_get_theme_option( 'posts_navigation_scroll_which_block', 'article' ) == 'article'
						) {
							do_action( 'yacht_rental_action_between_posts' );
						}

						// Widgets area above content
						yacht_rental_create_widgets_area( 'widgets_above_content' );

						do_action( 'yacht_rental_action_page_content_start_text' );
