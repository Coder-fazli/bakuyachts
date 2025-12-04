<?php
/**
 * The template to display the user's avatar, bio and socials on the Author page
 *
 * @package YACHT RENTAL
 * @since YACHT RENTAL 1.71.0
 */
?>

<div class="author_page author vcard"<?php
	if ( yacht_rental_is_on( yacht_rental_get_theme_option( 'seo_snippets' ) ) ) {
		?> itemprop="author" itemscope="itemscope" itemtype="<?php echo esc_attr( yacht_rental_get_protocol( true ) ); ?>//schema.org/Person"<?php
	}
?>>

	<div class="author_avatar"<?php
		if ( yacht_rental_is_on( yacht_rental_get_theme_option( 'seo_snippets' ) ) ) {
			?> itemprop="image"<?php
		}
	?>>
		<?php
		$yacht_rental_mult = yacht_rental_get_retina_multiplier();
		echo get_avatar( get_the_author_meta( 'user_email' ), 120 * $yacht_rental_mult );
		?>
	</div>

	<h4 class="author_title"<?php
		if ( yacht_rental_is_on( yacht_rental_get_theme_option( 'seo_snippets' ) ) ) {
			?> itemprop="name"<?php
		}
	?>><span class="fn"><?php the_author(); ?></span></h4>

	<?php
	$yacht_rental_author_description = get_the_author_meta( 'description' );
	if ( ! empty( $yacht_rental_author_description ) ) {
		?>
		<div class="author_bio"<?php
			if ( yacht_rental_is_on( yacht_rental_get_theme_option( 'seo_snippets' ) ) ) {
				?> itemprop="description"<?php
			}
		?>><?php echo wp_kses( wpautop( $yacht_rental_author_description ), 'yacht_rental_kses_content' ); ?></div>
		<?php
	}
	?>

	<div class="author_details">
		<span class="author_posts_total">
			<?php
			$yacht_rental_posts_total = count_user_posts( get_the_author_meta('ID'), 'post' );
			if ( $yacht_rental_posts_total > 0 ) {
				// Translators: Add the author's posts number to the message
				echo wp_kses( sprintf( _n( '%s article published', '%s articles published', $yacht_rental_posts_total, 'yacht-rental' ),
										'<span class="author_posts_total_value">' . number_format_i18n( $yacht_rental_posts_total ) . '</span>'
								 		),
							'yacht_rental_kses_content'
							);
			} else {
				esc_html_e( 'No posts published.', 'yacht-rental' );
			}
			?>
		</span><?php
			ob_start();
			do_action( 'yacht_rental_action_user_meta', 'author-page' );
			$yacht_rental_socials = ob_get_contents();
			ob_end_clean();
			yacht_rental_show_layout( $yacht_rental_socials,
				'<span class="author_socials"><span class="author_socials_caption">' . esc_html__( 'Follow:', 'yacht-rental' ) . '</span>',
				'</span>'
			);
		?>
	</div>

</div>
