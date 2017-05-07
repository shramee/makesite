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

if ( ! function_exists( 'makesite_ct_search' ) ) :
	/**
	 * Outputs content for search
	 * @action makesite_content_search
	 * @since 1.0.0
	 */
	function makesite_ct_search() {
		?>
		<header class="page-header">
			<h1 class="page-title"><?php printf( esc_html__( 'Search results for: %s', 'makesite' ), $_GET['s'] ); ?></h1>
		</header><!-- .page-header -->
		<?php
		while ( have_posts() ) : the_post();
			global $post;
			include get_query_template(
				'makesite_content_search',
				array(
					"content/search-{$post->post_name}.php",
					"content/search-{$post->ID}.php",
					"content/search-{$post->post_type}.php",
					"content/search.php",
					"content/archive-{$post->post_name}.php",
					"content/archive-{$post->ID}.php",
					"content/archive-{$post->post_type}.php",
					"content/archive.php",
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

if ( ! function_exists( 'makesite_ct_404' ) ) {
	/**
	 * Outputs the content for 404 page
	 */
	function makesite_ct_404() {
		?>
		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'makesite' ); ?></h1>
		</header><!-- .page-header -->
		<div class="page-content">
			<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'makesite' ); ?></p>
			<?php
			get_search_form();

			the_widget( 'WP_Widget_Recent_Posts' );

			makesite_ct_categories();

			/* translators: %1$s: smiley */
			$archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'makesite' ), convert_smilies( ':)' ) ) . '</p>';
			the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );

			the_widget( 'WP_Widget_Tag_Cloud' );
			?>
		</div><!-- .page-content -->
		<?php
	}
}
