<?php
/**
 * @developer wpdevelopment.me <shramee@wpdvelopment.me>
 */
function makesite() {
	?>
	<?php get_header(); ?>

	<div id="content" class="site-content">

		<?php
		/**
		 * Makesite render content
		 * @hook action makesite_content
		 * @hooked makesite_ct_open
		 * @hooked makesite_ct_loop
		 * @hooked makesite_ct_close
		 */
		do_action( 'makesite_content' );
		?>
		<?php get_sidebar() ?>
	</div><!-- #content -->
	<?php get_footer(); ?>

	<?php
}