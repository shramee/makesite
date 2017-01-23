<?php

/**
 * Class Makesite_Build
 * Initiate Makesite design
 */
class Makesite_Build {

	/** @var Makesite_Build Instance */
	protected static $instance;

	/**
	 * Returns instance of Makesite_Admin_Customizer
	 * @return Makesite_Build Instance
	 * @since 1.0.0
	 */
	public static function instance() {
		if ( empty( Makesite_Build::$instance ) ) {
			Makesite_Build::$instance = new Makesite_Build();
		}

		return Makesite_Build::$instance;
	}

	/**
	 * Magic constructor
	 * @since 1.0.0
	 */
	protected function __construct() {
		$this->hook( 'admin_print_styles-post-new.php', 'init' );
		$this->hook( 'admin_print_styles-post.php', 'init' );

	}

	/**
	 * Initiates the post builder
	 * @action admin_print_styles-post-new.php
	 * @action admin_print_styles-post.php
	 */
	public function init() {
		//global $post; //Do something with post
		$this->enqueue_styles();

		$this->hook( 'wp_default_scripts', 'build_js', 11 ); // Add after wp_default_scripts()
		$this->hook( 'media_buttons', 'builder_button' );

		$this->hook( 'admin_footer', 'panels' );
		$this->hook( 'admin_footer', 'enqueue_scripts', 16 );
	}

	/**
	 * Enqueues styles for post builder
	 */
	private function enqueue_styles() {
		wp_enqueue_style( 'makesite_build', MS_URL . 'inc/build/css/build.css' );
	}

	/**
	 * Outputs the panels html
	 * @action admin_footer
	 */
	public function panels() {
		include 'tpl.build.php';
	}

	/**
	 * Enqueues scripts for post builder
	 * @action admin_footer
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( 'makesite_build', MS_URL . 'inc/build/js/build.min.js' );
	}

	public function builder_button() {
		?>
		<button type="button" id="build-button" class="button">
			<span style="height:25px;line-height:25px;" class="dashicons dashicons-hammer"></span> Build page
		</button>
		#
		<button type="button" class="button">
			<span style="height:25px;line-height:25px;" class="dashicons dashicons-hammer"></span> Build page
		</button>
		<?php
	}

	/**
	 * Adds a method from this object as action/filter to given tag
	 * @param $tag string Tag to add method as callback to
	 * @param $method string Method to add as callback
	 * @param int $priority
	 * @param int $accepted_args
	 * @return true
	 */
	protected function hook( $tag, $method, $priority = 10, $accepted_args = 1 ) {
		return add_filter($tag, array( $this, $method ), $priority, $accepted_args);
	}

	/**
	 * Default WordPress scripts
	 * @param WP_Scripts $scripts
	 * @action wp_default_scripts
	 */
	public function build_js( $scripts ) {
		if ( is_admin() ) {
			$scripts->add( 'editor-expand', "/wp-admin/js/editor-expand.js", array( 'jquery' ), false, 1 );
		}
	}
}






