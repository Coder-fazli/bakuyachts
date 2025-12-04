<?php
/**
 * The template to display the 404 page
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.0
 */

get_header();

get_template_part( apply_filters( 'yacht_rental_filter_get_template_part', 'templates/content', '404' ), '404' );

get_footer();
