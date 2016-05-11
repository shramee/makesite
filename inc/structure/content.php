<?php

if ( ! function_exists( 'makesite_ct_page' ) ) :
	/**
	 * Outputs content for page
	 * @action makesite_content_page
	 * @since 1.0.0
	 */
	function makesite_ct_page() {
		while ( have_posts() ) : the_post();
			global $post;

			include get_query_template(
				'makesite_content_page',
				array(
					"content/page-{$post->post_name}.php",
					"content/page-{$post->ID}.php",
					"content/page.php",
				)
			);
		endwhile;
	}
endif;

if ( ! function_exists( 'makesite_ct_single' ) ) :
	/**
	 * Outputs content for single
	 * @action makesite_content_single
	 * @since 1.0.0
	 */
	function makesite_ct_single() {
		while ( have_posts() ) : the_post();
			global $post;
			include get_query_template(
				'makesite_content_single',
				array(
					"content/single-{$post->post_name}.php",
					"content/single-{$post->ID}.php",
					"content/single-{$post->post_type}.php",
					"content/single.php",
				)
			);
		endwhile;
	}
endif;

if ( ! function_exists( 'makesite_ct' ) ) :
	/**
	 * Outputs content for single
	 * @action makesite_content_single
	 * @since 1.0.0
	 */
	function makesite_ct() {

		if ( have_posts() ) : ?>

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();
				global $post;
				include get_query_template(
					'makesite_content_archive',
					array(
						"content/archive-{$post->post_type}.php",
						"content/archive.php",
					)
				);
			endwhile;

			makesite_pagination();

		else :

			get_template_part( 'content/none' );

		endif;
	}
endif;

if ( ! function_exists( 'makesite_ct_archive' ) ) :
	/**
	 * Outputs content for archive
	 * @action makesite_content_archive
	 * @since 1.0.0
	 */
	function makesite_ct_archive() {
		?>
		<header class="page-header">
			<?php
			the_archive_title( '<h1 class="page-title">', '</h1>' );
			the_archive_description( '<div class="taxonomy-description">', '</div>' );
			?>
		</header><!-- .page-header -->

		<?php makesite_ct();

	}
endif;
