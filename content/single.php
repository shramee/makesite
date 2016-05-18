<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package makesite
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php the_post_thumbnail( 'medium' ) ?>
	<header class="entry-header">
		<?php
		the_title( '<h1 class="entry-title">', '</h1>' );

		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php makesite_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php
		endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'makesite' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'makesite' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php makesite_entry_footer(); ?>
	</footer><!-- .entry-footer -->
	<?php
	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() ) :
		comments_template();
	endif;
	?>
</article><!-- #post-## -->
