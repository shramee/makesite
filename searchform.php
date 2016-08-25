<?php
/**
 * The template for displaying search form.
 * @package makesite
 */

$search_attrs = 'placeholder="' . esc_attr_x( 'Search &hellip;', 'makesite' ) . '" value="' . get_search_query() . '"';
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ) ?>">
	<label>
		<i class="pad icon-search right-abs"></i>
		<span class="screen-reader-text"><?php _ex( 'Search for:', 'label' ) ?></span>
		<input type="search" class="search-field" name="s" <?php echo $search_attrs ?>/>
	</label>
	<input type="submit" class="search-submit" value="<?php esc_attr_x( 'Search', 'submit button' ) ?>"/>
</form>