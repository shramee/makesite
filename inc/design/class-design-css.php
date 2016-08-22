<?php
/**
 * Adds css for customizer options
 * @package makesite
 * @since 1.0.0
 */

class Makesite_Design_Css extends Makesite_Design_Css_Fields {

	/** @var Makesite_Design_Css Instance */
	protected static $instance;

	/** @var array Styles data */
	protected $css;

	/** @var string Classes to add to body */
	protected $body_classes = '';

	/** @var array Google fonts to load */
	protected $gf_load  =array();

	/** @var array Google fonts */
	protected $gf_data;

	/** @var array Setting for current options group */
	protected $settings;

	/**
	 * Returns instance of Makesite_Design_Css
	 * @return Makesite_Design_Css
	 * @since 1.0.0
	 */
	public static function instance() {
		if ( empty( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function get_css() {
		$t = Makesite_Design_Css::instance();

		if ( empty( $t->css ) )
			$t->save_data();

		return $t->css;
	}

	/**
	 * Magic constructor
	 * @since 1.0.0
	 */
	protected function __construct() {
		$this->gf_data = ms_get_fonts( 'data' );
		if ( is_customize_preview() ) {
			$this->save_data();
		}
	}

	/**
	 * Generates CSS data from settings
	 * @action wp
	 * @uses Makesite_Design_Css::$styles, Makesite_Design_Css::$gf_load
	 * @since 1.0.0
	 */
	protected function process_settings() {
		$styles = '';

		$ms_fields = Makesite_Design::fields();
		foreach ( $ms_fields as $settings_group => $options ) {
			foreach( $options as $id => $f ) {

				$f['default'] = empty( $f['default'] ) ? '' : $f['default'];

				//Getting setting in a var
				$setting = get_option( $id, $f['default'] );

				if ( $this->is_field_css( $setting, $f ) ) {
					$styles .= $this->field_css(  $setting, $f['output'], $f );
				}
			}
		}
		$this->css = $styles;
	}

	protected function is_field_css( $setting, $f ) {

		if ( empty( $setting ) )
			return false;

		if ( ! empty( $f['body_class'] ) )
			$this->body_classes .= sprintf( $f['body_class'], $setting );

		if ( empty( $f['output'] ) )
			return false;

		return true;
	}

	protected function field_css( $setting, $output, $f ) {
		if ( is_array( $output ) ) {
			return ! empty( $output[ $setting ] ) ? $output[ $setting ] : '';
		}

		//Setting CSS vars
		return $this->get_style( $output, $setting, $f );
	}

	/**
	 * Outputs CSS from CSS data
	 * @action wp_head
	 * @uses Makesite_Design_Css::$styles
	 * @since 1.0.0
	 */
	protected function save_data() {
		if ( empty( $this->css ) ) {
			$this->process_settings();

			$makesite = array(
				'body_classes' => $this->body_classes,
				'css' => $this->css,
				'google_fonts' => $this->google_fonts_url(),
			);
			update_option( 'makesite_setting', $makesite );
		}
	}

	/**
	 * Registers Makesite control types to the liby customizer fields
	 * @action wp
	 * @uses Makesite_Design_Css::$styles, Makesite_Design_Css::$gf_load
	 * @return string google font url
	 * @since 1.0.0
	 */
	public function process_google_fonts() {
		foreach( $this->gf_load as $font => $weight ) {
			if ( 'Open Sans Condensed' == $font ) {
				$this->gf_load[ $font ] = array( '300' );
			} elseif ( strpos( $font, ' Light' ) ) {
				$this->gf_load[ str_replace( ' Light', '', $font ) ][] = '300';
			}
		}
	}

	/**
	 * Registers Makesite control types to the liby customizer fields
	 * @action wp
	 * @uses Makesite_Design_Css::$styles, Makesite_Design_Css::$gf_load
	 * @return string google font url
	 * @since 1.0.0
	 */
	public function google_fonts_url() {
		$this->process_google_fonts();

		$load_fonts = array();

		foreach( $this->gf_load as $font => $weight )
			$load_fonts[] = $font . ':' . implode( ':', $weight );

		if ( $load_fonts )
			return '//fonts.googleapis.com/css?family=' . join( '%7C', $load_fonts );

		return '';
	}
}