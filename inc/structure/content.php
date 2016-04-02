<?php
/**
 * Footer functions
 * @action makesite_content
 * @since 1.0.0
 *
 * @developer wpdevelopment.me <shramee@wpdvelopment.me>
 *
 * @package makesite
 */
if ( ! function_exists( 'makesite_ct_loop' ) ) :
	/**
	 * Outputs loop in content
	 * @action makesite_content
	 * @todo make it search call get_template_part for getting loop specific to the queried object
	 * @since 1.0.0
	 */
	function makesite_ct_loop() {
		$queried = get_class( get_queried_object() );
		echo "<h1>$queried</h1>";
		if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
	}
endif;
