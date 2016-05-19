<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package makesite
 */

if ( ! function_exists( 'makesite_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function makesite_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			esc_html_x( 'Posted on %s', 'post date', 'makesite' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		$byline = sprintf(
			esc_html_x( 'by %s', 'post author', 'makesite' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'makesite_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function makesite_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			makesite_post_entry_footer();
		}

		makesite_post_comments_count();

		edit_post_link(
			sprintf(
			/* translators: %s: Name of current post */
				esc_html__( 'Edit %s', 'makesite' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'makesite_post_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function makesite_post_entry_footer() {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'makesite' ) );
		if ( $categories_list ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'makesite' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'makesite' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'makesite' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}
endif;

if ( ! function_exists( 'makesite_post_comments_count' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function makesite_post_comments_count() {
		if ( ! is_single() && comments_open() ) {
			echo '<span class="comments-link">';
			comments_popup_link( esc_html__( 'Leave a comment', 'makesite' ), esc_html__( '1 Comment', 'makesite' ), esc_html__( '% Comments', 'makesite' ) );
			echo '</span>';
		}
	}
endif;

if ( ! function_exists( 'makesite_pagination' ) ) :
	function makesite_pagination() {
		$pagination = paginate_links( array( 'type' => 'list' ) );
		if ( ! empty( $pagination ) ) {
			echo "<div class='pagination'>$pagination</div>";
		}
	}
endif;

if ( ! function_exists( 'makesite_home_animation_data' ) ) :
	function makesite_home_animation_data() {
		$data = array(
			array(
				'img' => get_template_directory_uri() . '/img/home-animation/img1.jpg',
				'head' => 'Designed for Web Apps',
				'desc' => 'Specially handcrafted for heavy traffic websites/web apps.',
			),
			array(
				'img' => get_template_directory_uri() . '/img/home-animation/img2.jpg',
				'head'    => 'High extensibility',
				'desc'    => 'Tons of hooks to do what you want to without havnig to touch any of the theme code.',
			),
			array(
				'img' => get_template_directory_uri() . '/img/home-animation/img3.jpg',
				'head'    => 'Beautifully written code',
				'desc'    => 'Well documented code following the best coding practices.',
			),
			array(
				'img' => get_template_directory_uri() . '/img/home-animation/img4.jpg',
				'head'    => 'Performance',
				'desc'    => 'Designed for high performance necesarry for heavy traffic sites, <b>PHP 7 ready!</b>',
			),
		);

		$data[] = array(
			'content' => '<a class="lovely-scroll-down x2 flashing" href="javascript:void(0)">Scroll</a>',
			'desc'	=> 'Scroll Down',
			'head'	=> '',
			'class'	=> 'scroll-down',
		);

		return $data;
	}
endif;

if ( ! function_exists( 'makesite_home_animation' ) ) :
	function makesite_home_animation() {
		$data = makesite_home_animation_data();
		?>
		<div class="dnl-anm-screen bg-down">
			<div class='dnl-anm-wrap'>
				<?php
				$data = array_reverse( $data );
				$html = '';
				$total = count( $data );
				foreach ( $data as $id => $point ) {
					$html = makesite_home_animation_slide( $id, $point, $html, $total );
				}

				echo <<<HOME_ANIMATION
<div class='dnl-anm-iwrap'>
	$html
	<div class='line-reference' style='visibility: hidden;'></div>
</div>
HOME_ANIMATION;
				?>
			</div>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'makesite_home_animation_slide' ) ) :
	function makesite_home_animation_slide( $id, $point, $html, $total ) {
		$id    = $total - $id;
		$point = array_merge(
			array(
				'img'   => '',
				'head'  => '',
				'desc'  => '',
				'class' => '',
			),
			$point
		);
		if ( empty( $point['content'] ) ) {
			if ( $point['img'] ) {
				$point['content'] = "<img src='$point[img]'>";
			} else {
				return $html;
			}
		}
		$innerhtml = $html;
		$html  = <<<POINT
<div class='$point[class] line line$id'>
	<div class='point_wrap point_wrap$id' >
		<div class='point point$id'>$point[content]</div>
		<div class='info'>
			<h4>$point[head]</h4>
			<p>$point[desc]</p>
		</div>
	</div>
	$innerhtml
</div>
POINT;

		return $html;
	}
endif;