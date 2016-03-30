<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package makesite
 */

		/**
		 * Makesite render footer
		 * @hook action makesite_footer
		 * @hooked makesite_ft_open       - 10
		 * @hooked makesite_ft_skiplinks  - 20
		 * @hooked makesite_ft_info       - 30
		 * @hooked makesite_ft_navigation - 40
		 * @hooked makesite_ft_close      - 50
		 * @hooked wp_footer              - 70
		 */
		ms_do_action(
			'footer',
			'<footer id="colophon" class="site-footer" role="contentinfo"><div class="col-full">',
			'</div><!-- .col-full --></footer><!-- #colophon -->'
		);
		?>
	</div><!-- #page -->

	<?php wp_footer(); ?>

</body>
</html>
