<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package makesite
 */

function makesite_404_widgets() {
	get_search_form();

	the_widget( 'WP_Widget_Recent_Posts' );

// Only show the widget if site has multiple categories.
	?>

	<div class="widget widget_categories">
		<h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'makesite' ); ?></h2>
		<ul>
			<?php
			wp_list_categories( array(
				'orderby'    => 'count',
				'order'      => 'DESC',
				'show_count' => 1,
				'title_li'   => '',
				'number'     => 10,
			) );
			?>
		</ul>
	</div><!-- .widget -->

	<?php

	/* translators: %1$s: smiley */
	$archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'makesite' ), convert_smilies( ':)' ) ) . '</p>';
	the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );

	the_widget( 'WP_Widget_Tag_Cloud' );
}

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
		<?php makesite_404_widgets(); ?>
	</div><!-- .page-content -->
	<?php
}

ms_hook( 'content_404', 'makesite_ct_404' );

makesite( '404' );