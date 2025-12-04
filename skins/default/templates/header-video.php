<?php
/**
 * The template to display the background video in the header
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0.14
 */
$yacht_rental_header_video = yacht_rental_get_header_video();
$yacht_rental_embed_video  = '';
if ( ! empty( $yacht_rental_header_video ) && ! yacht_rental_is_from_uploads( $yacht_rental_header_video ) ) {
	if ( yacht_rental_is_youtube_url( $yacht_rental_header_video ) && preg_match( '/[=\/]([^=\/]*)$/', $yacht_rental_header_video, $matches ) && ! empty( $matches[1] ) ) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr( $matches[1] ); ?>"></div>
		<?php
	} else {
		?>
		<div id="background_video"><?php yacht_rental_show_layout( yacht_rental_get_embed_video( $yacht_rental_header_video ) ); ?></div>
		<?php
	}
}
